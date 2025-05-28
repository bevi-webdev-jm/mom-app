<?php

namespace App\Livewire\Moms\Topics;

use Livewire\Component;

class Item extends Component
{
    public $detail;
    public $view = 0;

    public function render()
    {
        return view('livewire.moms.topics.item');
    }

    public function mount($detail) {
        $this->detail = $detail;
    }

    public function changeView($view) {
        $this->view = $view;
    }
}
