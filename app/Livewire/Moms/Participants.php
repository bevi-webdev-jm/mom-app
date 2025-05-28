<?php

namespace App\Livewire\Moms;

use Livewire\Component;
use App\Models\User;

class Participants extends Component
{
    public $mom;
    public $selected_users = [];
    public $search_available, $search_selected;

    public function render()
    {
        // Get available users excluding the selected ones
        $users = User::orderBy('name', 'ASC')
            ->when(!empty($this->search_available), function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search_available . '%');
            })
            ->whereNotIn('id', array_keys($this->selected_users))
            ->get();

        // Filter selected users for display
        $filtered_selected_users = collect($this->selected_users)
            ->filter(function ($user) {
                return empty($this->search_selected)
                    || stripos($user->name, $this->search_selected) !== false;
            })
            ->sortBy('name');

        return view('livewire.moms.participants')->with([
            'filtered_selected_users' => $filtered_selected_users,
            'users' => $users
        ]);
    }

    public function mount($mom) {
        $this->mom = $mom;
        
        foreach($this->mom->participants as $participant) {
            $this->selected_users[$participant->id] = $participant;
        }
    }

    public function selectUser($user_id) {
        if (!isset($this->selected_users[$user_id])) {
            $user = User::find($user_id);
            if ($user) {
                $this->selected_users[$user_id] = $user;
            }
        }

        $this->saveParticipants();
        $this->dispatch('attendees-selected', selected: $this->selected_users);
    }

    public function unselectUser($user_id) {
        // Remove the user from selected_users
        unset($this->selected_users[$user_id]);

        $this->saveParticipants();
        $this->dispatch('attendees-selected', selected: $this->selected_users);
    }

    private function saveParticipants() {
        $changes_arr['old']['arr'] = $this->mom->participants->pluck('name');
        $this->mom->participants()->sync(array_keys($this->selected_users));
        $changes_arr['changes']['arr'] = $this->mom->participants->pluck('name');

        // logs
        activity('updated')
            ->performedOn($this->mom)
            ->withProperties($changes_arr)
            ->log(':causer.name has updated participants on :subject.mom_number');
    }
}
