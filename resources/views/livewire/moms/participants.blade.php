<div>
    <div class="card">
        <div class="card-header">
            <strong class="text-lg">{{__('adminlte::moms.attendees')}}</strong>
        </div>
        <div class="card-body py-1">

            <div class="row">
                <!-- SELECT -->
                <div class="col-6">
                    <div class="card mb-0">
                        <div class="card-header">
                            <strong>{{__('adminlte::moms.available')}}</strong>
                            <div class="card-tools">
                                <input type="text" class="form-control form-control-sm" wire:model.live="search_available" placeholder="{{__('adminlte::utilities.search')}}">
                            </div>
                        </div>
                        <div class="card-body scroll-box">
                            <ul class="list-group">
                                @foreach($users as $user)
                                    <a href="#" class="list-group-item py-1" wire:click.prevent="selectUser({{$user->id}})" wire:loading.attr="disabled">
                                        <strong class="text-dark">{{$user->name}}</strong>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <!-- SELECTED -->
                <div class="col-6">
                    <div class="card mb-0">
                        <div class="card-header">
                            <strong>{{__('adminlte::moms.selected')}}</strong>
                            <div class="card-tools">
                                <input type="text" class="form-control form-control-sm" wire:model.live="search_selected" placeholder="{{__('adminlte::utilities.search')}}">
                            </div>
                        </div>
                        <div class="card-body scroll-box">
                            <ul class="list-group">
                                @foreach($filtered_selected_users as  $user)
                                    <a href="#" class="list-group-item py-1" wire:click.prevent="unselectUser({{$user->id}})" wire:loading.attr="disabled">
                                        <strong class="text-dark">{{$user->name}}</strong>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>

    <style>
        .scroll-box {
            padding-top: 5px;
            padding-bottom: 5px;
            max-height: 250px;
            overflow-y: auto;
        }
    </style>
</div>
