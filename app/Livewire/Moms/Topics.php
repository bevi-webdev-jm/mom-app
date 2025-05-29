<?php

namespace App\Livewire\Moms;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

use App\Models\Mom;
use App\Models\MomDetail;
use App\Models\MomResponsible;
use App\Models\MomParticipant;

use App\Http\Traits\SettingTrait;

class Topics extends Component
{
    use SettingTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $mom;
    // 0 - list
    // 1 - add
    public $action_type = 0;
    public $responsibles = [];

    public $topic, $next_step, $target_date, $responsible_id;

    public function render()
    {
        $details = MomDetail::orderBy('created_at', 'DESC')
            ->where('mom_id', $this->mom->id)
            ->paginate($this->getDataPerPage(), ['*'], 'topic-page');

        return view('livewire.moms.topics')->with([
            'details' => $details
        ]);
    }

    public function mount($mom) {
        $this->mom = $mom;

        foreach($this->mom->participants as $participant) {
            $this->responsibles[] = $participant;
        }
    }

    public function changeType($type) {
        $this->action_type = $type;
    }

    #[On('attendees-selected')]
    public function updateResponsibles($selected) {
        $this->responsibles = $selected;
    }

    public function saveTopic() {
        $this->validate([
            'topic' => [
                'required'
            ],
            'next_step' => [
                'required'
            ],
            'target_date' => [
                'required'
            ],
            'responsible_id' => [
                'required'
            ]
        ]);

        $detail = MomDetail::create([
            'mom_id' => $this->mom->id,
            'topic' => $this->topic,
            'next_step' => $this->next_step,
            'target_date' => $this->target_date,
            'completed_date' => NULL,
            'remarks' => NULL,
            'status' => NULL,
        ]);

        $detail->responsibles()->sync($this->responsible_id);

        $this->changeType(0);
        $this->reset('topic', 'next_step', 'target_date', 'responsible_id');
    }
}
