<?php

namespace App\Livewire\Moms;

use Livewire\Component;

use App\Models\Mom;
use App\Models\MomType;

class Form extends Component
{
    public $mom, $type, $mom_number;
    public $mom_types;

    public $meeting_date, $type_id, $agenda;

    public function render()
    {
        return view('livewire.moms.form');
    }

    public function mount($mom) {
        $this->mom = $mom;
        $this->mom_number = $mom->mom_number;
        $this->meeting_date = $mom->meeting_date;

        $this->mom_types = MomType::orderBy('type', 'ASC')
            ->get();
    }

    
}
