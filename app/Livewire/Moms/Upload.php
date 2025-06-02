<?php

namespace App\Livewire\Moms;

use Livewire\Component;
use Livewire\WithFileUploads;

use Spatie\SimpleExcel\SimpleExcelReader;

use App\Models\User;

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
        // Convert immutable date to string, if needed
        if (isset($row['TARGET DATE']) && $row['TARGET DATE'] instanceof \DateTimeImmutable) {
            $row['TARGET DATE'] = $row['TARGET DATE']->format('Y-m-d'); // or any format you prefer
        }
        if (isset($row['DATE OF MEETING']) && $row['DATE OF MEETING'] instanceof \DateTimeImmutable) {
            $row['DATE OF MEETING'] = $row['DATE OF MEETING']->format('Y-m-d'); // or any format you prefer
        }

        $data = [
            'meeting_date' => $row['DATE OF MEETING'],
            'type' => $row['TYPE'],
            'topic' => $row['TOPIC'],
            'next_step' => $row['NEXT STEP'],
            'target_date' => $row['TARGET DATE'],
            'responsible' => $responsible->name ?? $row['RESPONSIBLE'],
            'action_plan' => $row['ACTION PLAN'],
            'status' => $row['STATUS'],
            'days_completed' => $row['DAYS COMPLETED'],
            'remarks' => $row['REMARKS']
        ];

        $this->mom_data[$row['CODE']][] = $data;
    }

    public function saveMom() {
        
    }
}
