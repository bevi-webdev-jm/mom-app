<div>
    
    @if($view == 0)
        <div class="callout callout-info topic-item" wire:click="changeView(1)">
            <h5><b>{{__('adminlte::moms.target_date')}}</b>: {{$detail->target_date}}</h5>
            <b>{{__('adminlte::moms.topic')}}:</b> {{$detail->topic}}
            <br>
            <b>{{__('adminlte::moms.next_step')}}:</b> {{$detail->next_step}}
            <br>
            <b>{{__('adminlte::moms.responsible')}}:</b> {{$detail->responsibles()->first()->name}}
        </div>
    @else
        <div class="card">
            <div class="card-header callout callout-info mb-0 pb-2">
                <div class="form-group row mb-0">
                    <label for="target_date" class="col-sm-2 col-form-label">{{__('adminlte::moms.target_date')}}</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control form-control-sm{{$errors->has('target_date') ? ' is-invalid' : ''}}" id="target_date" placeholder="{{__('adminlte::moms.target_date')}}" wire:model="target_date">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="topic" class="col-sm-2 col-form-label">{{__('adminlte::moms.topic')}}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control form-control-sm{{$errors->has('topic') ? ' is-invalid' : ''}}" id="topic" placeholder="{{__('adminlte::moms.topic')}}" wire:model="topic"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label for="next_step" class="col-sm-2 col-form-label">{{__('adminlte::moms.next_step')}}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control form-control-sm{{$errors->has('next_step') ? ' is-invalid' : ''}}" id="next_step" placeholder="{{__('adminlte::moms.next_step')}}" wire:model="next_step"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="responsible_id" class="col-sm-2 col-form-label">{{__('adminlte::moms.responsible')}}</label>
                    <div class="col-sm-10">
                        <select id="responsible_id" class="form-control{{$errors->has('responsible_id') ? ' is-invalid' : ''}}" wire:model="responsible_id">
                            <option value="">- {{__('adminlte::utilities.select')}} -</option>
                            @foreach($responsibles as $responsible)
                                <option value="{{$responsible['id']}}">{{$responsible['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button class="btn btn-secondary btn-xs" wire:click.prevent="changeView(0)">
                    <i class="fa fa-caret-left"></i>
                    {{__('adminlte::utilities.back')}}
                </button>

                <button class="btn btn-primary btn-xs" wire:click.prevent="updateDetail" wire:loading.attr="disabled">
                    <i class="fa fa-save fa-sm"></i>
                    {{__('adminlte::utilities.save')}}
                </button>
                
            </div>
            <div class="card-body callout callout-info mb-0">
                
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

