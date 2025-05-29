<?php

namespace App\Livewire\Moms\Topics;

use Livewire\Component;
use Livewire\Attributes\On;

class Item extends Component
{
    public $detail;
    public $view = 0;
    public $responsibles = [];

    public $target_date, $topic, $next_step, $responsible_id;

    public function render()
    {
        return view('livewire.moms.topics.item');
    }

    public function mount($detail, $responsibles) {
        $this->detail = $detail;
        
        $this->target_date = $detail->target_date;
        $this->topic = $detail->topic;
        $this->next_step = $detail->next_step;
        $this->responsible_id = $detail->responsibles()->first()->id;

        $this->responsibles = $responsibles;
    }

    public function changeView($view) {
        $this->view = $view;
    }

    #[On('attendees-selected')]
    public function updateResponsibles($selected) {
        $this->responsibles = $selected;
    }

    public function updateDetail() {
        $this->validate([
            'target_date' => [
                'required'
            ],
            'topic' => [
                'required'
            ],
            'next_step' => [
                'required'
            ],
            'responsible_id' => [
                'required'
            ]
        ]);
        
        $changes_arr['old'] = $this->detail->getOriginal();

        $this->detail->update([
            'target_date' => $this->target_date,
            'topic' => $this->topic,
            'next_step' => $this->next_step
        ]);

        $this->detail->responsibles()->sync($this->responsible_id);

        $changes_arr['changes'] = $this->detail->getChanges();

        // logs
        activity('updated')
            ->performedOn($this->detail)
            ->withProperties($changes_arr)
            ->log(':causer.name has updated topic :subject.topic');
    }
}
