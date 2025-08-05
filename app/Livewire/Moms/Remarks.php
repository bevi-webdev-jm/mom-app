<?php

namespace App\Livewire\Moms;

use Livewire\Component;

class Remarks extends Component
{
    public $mom;
    public $remarks;
    public $switch = 1;
    
    public function render()
    {
        return view('livewire.moms.remarks');
    }

    public function mount($mom) {
        $this->mom = $mom;
        $this->remarks = $mom->remarks;

        if(!empty($this->remarks)) {
            $this->switch = 0;
        }
    }

    public function saveRemarks() {
        $changes_arr['old'] = $this->mom->getOriginal();

        $this->mom->update([
            'remarks' => $this->remarks
        ]);

        $changes_arr['changes'] = $this->mom->getChanges();

        $this->switchEdit();

        // logs
        activity('updated')
            ->performedOn($this->mom)
            ->withProperties($changes_arr)
            ->log(':causer.name has updated the mom :subject.mom_number');
    }

    public function switchEdit() {
        if($this->switch == 1) {
            $this->switch = 0;
        } else if($this->switch == 0) {
            $this->switch = 1;
        }
    }
}
