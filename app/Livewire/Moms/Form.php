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
        $this->type_id = $mom->mom_type_id;
        $this->agenda = $mom->agenda;

        $this->mom_types = MomType::orderBy('type', 'ASC')
            ->get();
    }

    public function saveMom($status) {
        $this->validate([
            'meeting_date' => [
                'required'
            ],
            'type_id' => [
                'required'
            ],
            'agenda' => [
                'required'
            ]
        ]);

        $changes_arr['old'] = $this->mom->getOriginal();

        $this->mom->update([
            'mom_type_id' => $this->type_id,
            'agenda' => $this->agenda,
            'meeting_date' => $this->meeting_date,
            'status' => $status,
        ]);

        $changes_arr['changes'] = $this->mom->getChanges();

        // logs
        activity('updated')
            ->performedOn($this->mom)
            ->withProperties($changes_arr)
            ->log(':causer.name has updated the mom :subject.mom_number');
    }
}
