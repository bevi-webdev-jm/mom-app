<div>
    
    @if($view == 0)
        <div class="callout callout-info topic-item" 
            wire:click="changeView(1)">
            <h5><b>{{__('adminlte::moms.target_date')}}</b>: {{$detail->target_date}}</h5>
            <b>{{__('adminlte::moms.topic')}}:</b> {{$detail->topic}}
            <br>
            <b>{{__('adminlte::moms.next_step')}}:</b> {{$detail->next_step}}
            <br>
            <b>{{__('adminlte::moms.responsible')}}:</b> {{!empty($responsible_id) ? collect($responsibles)->where('id', $responsible_id)->first()['name'] : '-'}}
            <br>
            <b>{{__('adminlte::utilities.status')}}:</b> <span class="badge badge-{{$status_arr[$detail->status]}}">{{$detail->status}}</span>
            @if(!empty($this->days_completed))
                <br>
                <b>{{__('adminlte::moms.days_completed')}}:</b>
                {{$days_completed}}
            @endif
        </div>
    @else
        <div class="card">
            <div class="card-header callout callout-info mb-0 pb-2">

                @if(!empty($messages['success']))
                    <div class="alert alert-success">
                        <strong>{{$messages['success']}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($type == 'form')
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
                        {{__('adminlte::utilities.update')}}
                    </button>
                @else
                    <h5><b>{{__('adminlte::moms.target_date')}}</b>: {{$detail->target_date}}</h5>
                    <b>{{__('adminlte::moms.topic')}}:</b> {{$detail->topic}}
                    <br>
                    <b>{{__('adminlte::moms.next_step')}}:</b> {{$detail->next_step}}
                    <br>
                    <b>{{__('adminlte::moms.responsible')}}:</b> {{$detail->responsibles()->first()->name ?? '-'}}
                    <br>
                    <b>{{__('adminlte::utilities.status')}}:</b> <span class="badge badge-{{$status_arr[$detail->status]}}">{{$detail->status}}</span>
                    <br>
                    <b>{{__('adminlte::moms.completed_date')}}:</b> {{$detail->completed_date}}
                    @if(!empty($this->days_completed))
                        <br>
                        <b>{{__('adminlte::moms.days_completed')}}:</b>
                        {{$days_completed}}
                    @endif
                @endif
                
            </div>
            @if(in_array(auth()->user()->id, $detail->responsibles()->pluck('id')->toArray()))
                <div class="card-body callout callout-warning mb-0">
                    @if($type == 'show')
                        <button class="btn btn-secondary btn-xs" wire:click.prevent="changeView(0)">
                            <i class="fa fa-caret-left"></i>
                            {{__('adminlte::utilities.back')}}
                        </button>

                        <br>
                    @endif

                    <strong class="text-lg">{{__('adminlte::moms.actions_taken')}}</strong>
                    <hr class="mt-0">
                    
                    @if($detail->status !== 'completed')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="actions_taken">{{__('adminlte::moms.actions_taken')}}</label>
                                    <textarea id="actions_taken" class="form-control{{$errors->has('actions_taken') ? ' is-invalid' : ''}}" wire:model="actions_taken" placeholder="{{__('adminlte::moms.actions_taken')}}"></textarea>
                                    <small class="text-danger">{{$errors->first('actions_taken')}}</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="remarks">{{__('adminlte::utilities.remarks')}}</label>
                                    <textarea id="remarks" class="form-control{{$errors->has('remarks') ? ' is-invalid' : ''}}" wire:model="remarks" placeholder="{{__('adminlte::utilities.remarks')}}"></textarea>
                                    <small class="text-danger">{{$errors->first('remarks')}}</small>
                                </div>
                            </div>
                        </div>

                        <strong class="text-lg">{{__('adminlte::moms.attachments')}}</strong>
                        <hr class="mt-0">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="attachments">{{__('adminlte::moms.attachments')}}</label>
                                    <input type="file" class="form-control{{$errors->has('attachments') ? ' is-invalid' : ''}}" wire:model="attachments" multiple>
                                    <small class="text-danger">{{$errors->first('attachments')}}</small>
                                </div>
                            </div>
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>{{__('adminlte::moms.attachment_file')}}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($detail->actions->count()) && !empty($detail->actions()->first()->attachments()->count()))
                                            @foreach($detail->actions()->first()->attachments as $attachment)
                                                <tr>
                                                    <td>
                                                        <a href="{{asset($attachment->path)}}" class="text-primary">
                                                            {{$attachment->path}}
                                                        </a>
                                                    </td>
                                                    <td class="p-0 text-center align-middle">
                                                        <button class="btn btn-danger btn-xs" wire:click.prevent="removeAttachment({{$attachment->id}})">
                                                            <i class="fa fa-trash-alt"></i>
                                                            {{__('adminlte::utilities.remove')}}
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center align-middle">
                                                    {{__('adminlte::utilities.no_data_available')}}
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary btn-sm" wire:click.prevent="saveAction" wire:loading.attr="disabled">
                                    <i class="fa fa-save mr-1"></i>
                                    {{__('adminlte::utilities.save')}}
                                </button>
                                @if(!empty($detail->actions->count()))
                                    <button class="btn btn-success btn-sm" wire:click.prevent="completeTopic" wire:loading.attr="disabled">
                                        <i class="fa fa-check mr-1"></i>
                                        {{__('adminlte::moms.completed')}}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @else
                        @php
                            $action = $detail->actions()->first();
                        @endphp
                        <b>{{__('adminlte::moms.actions_taken')}}:</b> {{$action->action_taken}}
                        <br>
                        <b>{{__('adminlte::utilities.remarks')}}:</b> {{$action->remarks}}
                        <br>

                        <strong class="text-lg">{{__('adminlte::moms.attachments')}}</strong>
                        <hr class="mt-0">

                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>{{__('adminlte::moms.attachment_file')}}</th>
                                    <th>{{__('adminlte::utilities.remarks')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($detail->actions->count()) && !empty($detail->actions()->first()->attachments()->count()))
                                    @foreach($detail->actions()->first()->attachments as $attachment)
                                        <tr>
                                            <td>
                                                <a href="{{asset($attachment->path)}}" class="text-primary">
                                                    {{$attachment->path}}
                                                </a>
                                            </td>
                                            <td>
                                                {{$attachment->remarks}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    @endif
                    
                </div>
            @endif
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

