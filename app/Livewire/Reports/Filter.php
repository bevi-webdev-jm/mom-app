<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\User;

class Filter extends Component
{
    public $users;
    public $selected_users = [];
    public $search_available, $search_selected;

    public function render()
    {
        // Get available users excluding the selected ones
        $this->users = User::orderBy('name', 'ASC')
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

        return view('livewire.reports.filter')->with([
            'filtered_selected_users' => $filtered_selected_users,
            'users' => $this->users
        ]);
    }

    public function selectUser($user_id) {
        if (!isset($this->selected_users[$user_id])) {
            $user = User::find($user_id);
            if ($user) {
                $this->selected_users[$user_id] = $user;
            }
        }

        $this->dispatch('filter-user-selected', selected: $this->selected_users);
    }

    public function unselectUser($user_id) {
        // Remove the user from selected_users
        unset($this->selected_users[$user_id]);
        $this->dispatch('filter-user-selected', selected: $this->selected_users);
    }

    public function selectAll() {
        foreach($this->users as $user) {
            $this->selected_users[$user->id] = $user;
            $this->dispatch('filter-user-selected', selected: $this->selected_users);
        }
    }

    public function clearSelected() {
        $this->selected_users = [];
        $this->dispatch('filter-user-selected', selected: $this->selected_users);
    }
}
