<?php

namespace App\Livewire\Moms;

use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Helpers\MomNumberHelper;
use App\Models\User;
use App\Models\Mom;
use App\Models\MomType;
use App\Models\MomDetail;

class Upload extends Component
{
    use WithFileUploads;
    
    public $upload_file;
    public $mom_data;

    public function render()
    {
        return view('livewire.moms.upload');
    }

    public function checkData() {
        $this->validate([
            'upload_file' => [
                'required',
                'file',
                'mimes:csv,xlsx,txt'
            ]
        ]);

        $path = $this->upload_file->store('mom-uploads');
        $fullPath = storage_path("app/{$path}");

        $this->mom_data = [];
        // Read rows using Spatie SimpleExcel
        SimpleExcelReader::create($fullPath)
            ->getRows()
            ->each(function(array $row) {
                $this->processRow($row);
            });
    }

    private function processRow($row) {

        // find responsible name from users
        $responsible = User::where('name', $row['RESPONSIBLE'])->first();
        // find type from mom types
        $type = MomType::where('type', $row['TYPE'])->first();
        // Convert immutable date to string, if needed
        if (isset($row['TARGET DATE']) && $row['TARGET DATE'] instanceof \DateTimeImmutable) {
            $row['TARGET DATE'] = $row['TARGET DATE']->format('Y-m-d'); // or any format you prefer
        }
        if (isset($row['DATE OF MEETING']) && $row['DATE OF MEETING'] instanceof \DateTimeImmutable) {
            $row['DATE OF MEETING'] = $row['DATE OF MEETING']->format('Y-m-d'); // or any format you prefer
        }

        $header = [
            'meeting_date' => $row['DATE OF MEETING'],
            'type' => $type->type ?? $row['TYPE'],
            'type_model' => $type ?? NULL,
            'agenda' => $row['AGENDA'],
        ];

        $data = [
            'topic' => $row['TOPIC'],
            'next_step' => $row['NEXT STEP'],
            'target_date' => $row['TARGET DATE'],
            'responsible' => $responsible->name ?? $row['RESPONSIBLE'],
            'responsible_model' => $responsible ?? NULL,
            'action_plan' => $row['ACTION PLAN'],
            'status' => $row['STATUS'],
            'days_completed' => $row['DAYS COMPLETED'],
            'remarks' => $row['REMARKS'],
        ];

        $this->mom_data[$row['CODE']]['header'] = $header;
        $this->mom_data[$row['CODE']]['topics'][] = $data;
    }

    public function saveMom() {
        foreach($this->mom_data as $mom_number => $mom_val) {
            $mom = Mom::create([
                'mom_type_id' => $mom_val['header']['type_model']['id'] ?? NULL,
                'user_id' => auth()->user()->id,
                'mom_number' => MomNumberHelper::generateMomNumber($mom_number),
                'agenda' => $mom_val['header']['agenda'] ?? '',
                'meeting_date' => $mom_val['header']['meeting_date'] ?? date('Y-m-d'),
                'status' => 'draft',
            ]);

            $attendees_ids = [];
            foreach($mom_val['topics'] as $topic) {
                $mom_detail = MomDetail::create([
                    'mom_id' => $mom->id,
                    'topic' => $topic['topic'],
                    'next_step' => $topic['next_step'],
                    'target_date' => date('Y-m-d', strtotime($topic['target_date'])),
                    'completed_date' => NULL,
                    'remarks' => $topic['remarks'],
                    'status' => 'open',
                ]);

                if(!empty($topic['responsible_model'])) {
                    $mom_detail->responsibles()->sync($topic['responsible_model']['id']);

                    $attendees_ids[] = $topic['responsible_model']['id'];
                }
            }

            $mom->participants()->sync($attendees_ids);
        }

        return redirect()->route('mom.index')->with([
            'message_success' => __('adminlte::moms.mom_uploaded')
        ]);
    }
}
