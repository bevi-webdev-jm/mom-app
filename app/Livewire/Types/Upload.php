<?php

namespace App\Livewire\Types;

use Livewire\Component;
use Livewire\WithFileUploads;

use Spatie\SimpleExcel\SimpleExcelReader;

use App\Models\MomType;

class Upload extends Component
{
    use WithFileUploads;

    public $file;

    public $types_data = [];

    public function render()
    {
        return view('livewire.types.upload');
    }

    public function checkFile() {
        $this->validate([
            'file' => [
                'required',
                'file',
                'mimes:csv,xlsx,txt'
            ]
        ]);

        $path = $this->file->store('type-uploads');
        $fullPath = storage_path("app/{$path}");

        $this->types_data = [];
        // Read rows using Spatie SimpleExcel
        SimpleExcelReader::create($fullPath)
            ->getRows()
            ->each(function(array $row) {
                if(!empty($row['TYPES'])) {
                    $this->types_data[] = $row['TYPES'];
                }
            });
            
    }

    public function saveTypes() {

        foreach($this->types_data as $type_val) {
            $type = MomType::where('type', $type_val)
                ->first();

            if(empty($type)) {
                $type = new MomType([
                    'type' => $type_val
                ]);
                $type->save();
            }
        }

        return redirect(request()->header('Referer'))->with([
            'message_success' => __('adminlte::types.type_upload_success')
        ]);
    }

}
