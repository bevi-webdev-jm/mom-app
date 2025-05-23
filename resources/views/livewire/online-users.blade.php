<div>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('adminlte::utilities.online_users')}}</h4>
        </div>
        <div class="modal-body">
            <ul class="list-group" wire:poll.visible.3000ms>
                @foreach($users as $user)
                    <li class="list-group-item">
                        {{$user->name}}
                        @if($user->isOnline())
                            <span class="text-success float-right">{{__('adminlte::utilities.online')}}</span>
                        @elseif(!empty($user->last_activity))
                            <span class="text-secondary float-right">{{ Carbon\Carbon::parse($user->last_activity)->diffForHumans() }}</span>
                        @else
                            <span class="text-secondary float-right">{{__('adminlte::utilities.offline')}}</span>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="row mt-2">
                <div class="col-12">
                </div>
            </div>
        </div>
        <div class="modal-footer text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{__('adminlte::utilities.close')}}</button>
        </div>
    </div>
</div>
