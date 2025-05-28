<?php

namespace App\Livewire\Moms;

use Livewire\Component;

class Topics extends Component
{
    // 0 - list
    // 1 - add
    // 2 - actions
    public $action_type = 0;

    public function render()
    {
        return view('livewire.moms.topics');
    }

    public function changeType($type) {
        $this->action_type = $type;
    }
}
