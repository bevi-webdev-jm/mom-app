<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;

use App\Models\{
    User, Company, Role, MomType, Mom, Location
};

class DeleteModel extends Component
{
    public $password;
    public $error_message;
    public $model;
    public $name;
    public $model_route;
    public $type;

    protected $listeners = [
        'setDeleteModel' => 'setModel'
    ];

    public function render()
    {
        return view('livewire.delete-model');
    }

    public function submitForm() {
        $this->error_message = '';

        // Temporarily disable password requirement
        // To re-enable, uncomment the validation and password check below
        
        // $this->validate([
        //     'password' => 'required'
        // ]);

        // // check password
        // if(!Hash::check($this->password, auth()->user()->password)) { // invalid
        //     $this->error_message = 'incorrect password.';
        // } else { // delete function
        
        // Skip password check for temporary disable
        $this->model->delete();

        activity('delete')
            ->performedOn($this->model)
            ->withProperties($this->model)
            ->log(':causer.name has deleted '.$this->type.' ['.$this->name.']');

        return redirect()->to($this->model_route)->with([
            'message_success' => $this->type.' ['.$this->name.'] was deleted successfully.'
        ]);
    }

    public function setModel($type, $model_id) {
        $model_id = decrypt($model_id);
        $this->type = $type;

        $modelMapping = [
            'Company' => ['model' => Company::class, 'route' => '/companies'],
            'User' => ['model' => User::class, 'route' => '/users'],
            'Role' => ['model' => Role::class, 'route' => '/roles'],
            'MomType' => ['model' => MomType::class, 'route' => '/mom-types'],
            'Mom'   => ['model' => Mom::class, 'route' => '/moms'],
            'Location' => ['model' => Location::class, 'route' => '/locations'],
        ];

        if (isset($modelMapping[$type])) {
            $this->model = app($modelMapping[$type]['model'])::findOrFail($model_id);
            $this->name = $this->model->name;
            $this->model_route = $modelMapping[$type]['route'];
        } else {
            throw new \InvalidArgumentException("Invalid model type: {$type}");
        }
    }
    
}
