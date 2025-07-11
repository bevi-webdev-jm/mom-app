<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <strong class="text-lg">{{__('adminlte::utilities.filter')}}</strong>
                </div>
            </div>
        </div>
        <div class="card-body">
            
            <div class="row">
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
                        <div class="card-footer text-right">
                            @if(count($users) > 0)
                                <button class="btn btn-primary btn-sm" wire:click.prevent="selectAll" wire:loading.attr="disabled">Select All</button>
                            @endif
                        </div>
                    </div>
                    
                </div>
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
                        <div class="card-footer text-right">
                            @if(!empty($selected_users))
                                <button class="btn btn-secondary btn-sm" wire:click.prevent="clearSelected" wire:loading.attr="disabled">Clear Selection</button>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="status">{{__('adminlte::utilities.status')}}</label>
                        <select id="status" class="form-control" wire:model.live="status">
                            <option value="">All</option>
                            @foreach ($status_arr as $status => $val)
                                <option value="{{$status}}">{{$status}}</option>               
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .scroll-box {
            padding-top: 5px;
            padding-bottom: 5px;
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</div>