<div>
    <div class="card">
        <div class="card-header">
            <strong class="text-lg">{{__('adminlte::moms.topics_to_solve')}}</strong>
            <div class="card-tools">
                <button class="btn btn-primary btn-sm" wire:click.prevent="changeType(1)">
                    <i class="fa fa-plus mr-1"></i>
                    {{__('adminlte::moms.add_topic')}}
                </button>
            </div>
        </div>
        <div class="card-body">

            @if($action_type == 0)
                <!-- LIST -->
                <ul class="list-group" wire:transition>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-4">
                                <strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas dicta recusandae maiores praesentium asperiores rerum explicabo inventore natus quis voluptate, dignissimos, error sit nostrum vel obcaecati doloremque, libero dolorem cum.</strong>
                            </div>
                            <div class="col-lg-4 text-center">
                                <strong>
                                    {{auth()->user()->name}}
                                </strong>
                            </div>
                            <div class="col-lg-4 text-center">
                                <strong>{{date('Y-m-d')}}</strong>
                            </div>
                        </div>
                    </li>
                </ul>
            @elseif($action_type == 1)
                <!-- ADD -->
                <div class="card" wire:transition>
                    <div class="card-header">
                        <strong>{{__('adminlte::moms.add_topic')}}</strong>
                        <div class="card-tools">
                            <button class="btn btn-primary btn-sm" wire:click.prevent="changeType(0)">
                                <i class="fa fa-list mr-1"></i>
                                {{__('adminlte::moms.topic_list')}}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            @endif
            
        </div>
    </div>
</div>
