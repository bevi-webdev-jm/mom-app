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
                <ul class="list-group">
                    @foreach($details as $detail)
                        <livewire:moms.topics.item :detail="$detail" :responsibles="$responsibles" :key="$detail->id"/>
                    @endforeach
                </ul>

                <div class="row">
                    <div class="col-12">
                        {{$details->links()}}
                    </div>
                </div>
            @elseif($action_type == 1)
                <!-- ADD -->
                <div class="card">
                    <div class="card-header">
                        <strong>{{__('adminlte::moms.add_topic')}}</strong>
                        <div class="card-tools">
                            <button class="btn btn-secondary btn-sm" wire:click.prevent="changeType(0)">
                                <i class="fa fa-list mr-1"></i>
                                {{__('adminlte::moms.topic_list')}}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="topic">{{__('adminlte::moms.topic')}}</label>
                                    <textarea class="form-control{{$errors->has('topic') ? ' is-invalid' : ''}}" id="topic" wire:model="topic" placeholder="{{__('adminlte::moms.topic')}}"></textarea>
                                    <small class="text-danger">{{$errors->first('topic')}}</small>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="next_step">{{__('adminlte::moms.next_step')}}</label>
                                    <textarea class="form-control{{$errors->has('next_step') ? ' is-invalid' : ''}}" id="next_step" wire:model="next_step" placeholder="{{__('adminlte::moms.next_step')}}"></textarea>
                                    <small class="text-danger">{{$errors->first('next_step')}}</small>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="target_date">{{__('adminlte::moms.target_date')}}</label>
                                    <input type="date" class="form-control{{$errors->has('target_date') ? ' is-invalid' : ''}}" id="target_date" wire:model="target_date" placeholder="{{__('adminlte::moms.target_date')}}">
                                    <small class="text-danger">{{$errors->first('target_date')}}</small>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="responsible_id">{{__('adminlte::moms.responsible')}}</label>
                                    <select id="responsible_id" class="form-control{{$errors->has('responsible_id') ? ' is-invalid' : ''}}" wire:model="responsible_id">
                                        <option value="">- {{__('adminlte::utilities.select')}} -</option>
                                        @foreach($responsibles as $responsible)
                                            <option value="{{$responsible['id']}}">{{$responsible['name']}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{$errors->first('responsible_id')}}</small>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary btn-sm" wire:click.prevent="saveTopic" wire:loading.attr="disabled">
                            <i class="fa fa-save mr-1"></i>
                            {{__('adminlte::moms.save_topic')}}
                        </button>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</div>
