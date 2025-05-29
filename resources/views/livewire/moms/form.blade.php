<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <strong class="badge badge-secondary text-uppercase text-lg">{{$mom->status}}</strong>
                </div>
                <div class="col-lg-6 text-right">
                    <button class="btn btn-primary btn-sm" wire:click.prevent="saveMom('draft')">
                        <i class="fa fa-save mr-1"></i>
                        {{__('adminlte::moms.save_as_draft')}}
                    </button>
                    <button class="btn btn-success btn-sm" wire:click.prevent="saveMom('submitted')">
                        <i class="fa fa-save mr-1"></i>
                        {{__('adminlte::utilities.submit')}}
                    </button>
                    <a href="{{route('mom.index')}}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-caret-left"></i>
                        {{__('adminlte::utilities.back')}}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header py-2">
                    <div class="row">
                        <div class="col-lg-6 align-middle">
                            <strong class="text-lg">{{__('adminlte::moms.new_mom')}}</strong>
                        </div>
                        <div class="col-lg-6 text-right">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <strong class="text-lg">{{__('adminlte::moms.mom_number')}}:</strong>
                            <strong class="badge badge-success text-lg">{{$mom_number}}</strong>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="meeting_date">{{__('adminlte::moms.meeting_date')}}</label>
                                <input type="date" class="form-control{{$errors->has('meeting_date') ? ' is-invalid' : ''}}" id="meeting_date" wire:model="meeting_date">
                                <small class="text-danger">{{$errors->first('meeting_date')}}</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="type_id">{{__('adminlte::moms.mom_type')}}</label>
                                <select class="form-control{{$errors->has('type_id') ? ' is-invalid' : ''}}" id="type_id" wire:model="type_id">
                                    <option value="">- select -</option>
                                    @foreach($mom_types as $type)
                                        <option value="{{$type->id}}">{{$type->type}}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger">{{$errors->first('type_id')}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="agenda">{{__('adminlte::moms.agenda')}}</label>
                                <textarea id="agenda" class="form-control{{$errors->has('agenda') ? ' is-invalid' : ''}}" wire:model="agenda" placeholder="{{__('adminlte::moms.agenda_placeholder')}}"></textarea>
                                <small class="text-danger">{{$errors->first('agenda')}}</small>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            @livewire('moms.participants', ['mom' => $mom])
        </div>

        <div class="col-12">
            @livewire('moms.topics', ['mom' => $mom])
        </div>
    </div>
    
</div>
