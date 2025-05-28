<div>
    @if($view == 0)
        <div class="callout callout-info topic-item" wire:click="changeView(1)">
            <h5><b>{{__('adminlte::moms.target_date')}}</b>: {{$detail->target_date}}</h5>
            <b>{{__('adminlte::moms.topic')}}:</b> {{$detail->topic}}
            <br>
            <b>{{__('adminlte::moms.next_step')}}:</b> {{$detail->next_step}}
            <br>
            <b>{{__('adminlte::moms.responsible')}}:</b> {{$detail->responsibles()->first()->user->name}}
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>{{__('adminlte::moms.target_date')}}</b>{{$detail->target_date}}</h3>
                <div class="card-tools">
                    <button class="btn btn-secondary btn-sm" wire:click.prevent="changeView(0)">
                        <i class="fa fa-caret-left"></i>
                        {{__('adminlte::utilities.back')}}
                    </button>
                </div>
            </div>
            <div class="card-body">

            </div>
        </div>
    @endif

    <style>
        .topic-item {
            transition: all 0.3s ease;
            border-radius: 5px;
            cursor: pointer;
        }

        .topic-item:hover {
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</div>

