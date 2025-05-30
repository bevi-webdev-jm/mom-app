<?php

namespace App\Livewire\Moms\Topics;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

use App\Helpers\FileSavingHelper;
use Carbon\Carbon;

use App\Models\MomAction;
use App\Models\MomActionAttachment;

class Item extends Component
{
    use WithFileUploads;

    public $detail;
    public $type;
    public $view = 0;
    public $responsibles = [];

    public $target_date, $topic, $next_step, $responsible_id;
    public $actions_taken, $remarks, $attachments;

    public $days_completed;

    public $status_arr = [
        'open' => 'secondary',
        'ongoing' => 'info',
        'extended' => 'warning',
        'completed' => 'success',
    ];

    public function render()
    {
        return view('livewire.moms.topics.item');
    }

    public function mount($detail, $responsibles, $type) {
        $this->detail = $detail;
        $this->responsibles = $responsibles;
        $this->type = $type;
        
        $this->target_date = $detail->target_date;
        $this->topic = $detail->topic;
        $this->next_step = $detail->next_step;
        $this->responsible_id = $detail->responsibles()->first()->id;

        if(!empty($this->detail->actions->count())) {
            $action = $this->detail->actions()->first();
            $this->actions_taken = $action->action_taken;
            $this->remarks = $action->remarks;
        }

        $this->checkDaysExtended();
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

    private function checkDaysExtended() {
        if($this->detail->status !== 'completed') {
            $currentDate = Carbon::today();
            $targetDate = Carbon::parse($this->detail->target_date);
  
            if ($targetDate->lt($currentDate)) {
                // Target date is **before** current date (past due)
                $this->detail->update([
                    'status' => 'extended'
                ]);
            } elseif ($targetDate->gt($currentDate)) {
                // Target date is **after** current date (still time left)
                if(!empty($this->detail->actions->count())) {
                    $this->detail->update([
                        'status' => 'ongoing'
                    ]);
                }
            } else {
                // Target date is **today**
                if(!empty($this->detail->actions->count())) {
                    $this->detail->update([
                        'status' => 'ongoing'
                    ]);
                }
            }
        } else {
            // Compute days completed
            $completedDate = Carbon::parse($this->detail->completed_date);
            $targetDate = Carbon::parse($this->detail->target_date);

            $daysToComplete = $completedDate->diffInDays($targetDate, false); // false = returns negative if completed before target

            $this->days_completed = $daysToComplete;
        }
    }

    public function saveAction() {
        $this->validate([
            'actions_taken' => [
                'required'
            ],
            'remarks' => [
                'max:255'
            ],
        ]);

        // check if already exists
        $action = MomAction::where('mom_detail_id', $this->detail->id)
            ->first();

        if(!empty($action)) {
            $action->update([
                'action_taken' => $this->actions_taken,
                'remarks' => $this->remarks
            ]);
        } else {
            $action = MomAction::create([
                'mom_detail_id' => $this->detail->id,
                'user_id' => auth()->user()->id,
                'action_taken' => $this->actions_taken,
                'remarks'   => $this->remarks,
            ]);
        }

        if(!empty($this->attachments)) {
            foreach($this->attachments as $attachment) {
                $path = FileSavingHelper::saveFile($attachment, $action->id, 'mom');
                $action_attachment = MomActionAttachment::create([
                    'mom_action_id' => $action->id,
                    'path' => $path,
                    'remarks' => NULL
                ]);
            }
        }

        $this->checkDaysExtended();
    }

    public function completeTopic() {
        $this->saveAction();
        
        $this->detail->update([
            'completed_date' => date('Y-m-d'),
            'status' => 'completed'
        ]);
        
        $this->checkDaysExtended();
    }
} 
