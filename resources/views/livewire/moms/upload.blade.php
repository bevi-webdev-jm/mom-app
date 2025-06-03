<div>
    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-lg-6 align-middle">
                    <strong class="text-lg">{{__('adminlte::moms.upload_mom')}}</strong>
                </div>
                <div class="col-lg-6 text-right">
                    <a href="{{route('mom.index')}}" class="btn btn-secondary btn-xs">
                        <i class="fa fa-caret-left"></i>
                        {{__('adminlte::utilities.back')}}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-lg-3">
                    <label for="upload_file">{{__('adminlte::moms.upload_file')}}</label>
                    <input type="file" class="form-control{{$errors->has('upload_file') ? ' is-invalid' : ''}}" wire:model="upload_file">
                    <small class="text-danger">{{$errors->first('upload_file')}}</small>
                </div>

                <div class="col-12 mt-2">
                    <button class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:click.prevent="checkData">
                        <i class="fa fa-check" wire:loading.remove></i>
                        <i class="fa fa-spinner fa-spin" wire:loading></i>
                        {{__('adminlte::utilities.check')}}
                    </button>
                </div>
            </div>

        </div>
        <div class="card-footer text-right">
            @if(!empty($mom_data))
                <button class="btn btn-primary btn-sm" wire:click.prevent="saveMom" wire:loading.attr="disabled">
                    <i class="fa fa-save" wire:loading.remove></i>
                    <i class="fa fa-spinner fa-spin" wire:loading></i>
                    {{__('adminlte::utilities.save')}}
                </button>
            @endif
        </div>
    </div>

    @if(!empty($mom_data))
        @foreach($mom_data as $mom_number => $mom_arr)
            <div class="card card-outline card-primary mt-2" wire:transition>
                <div class="card-header">
                    <h5>
                        <b>{{__('adminlte::moms.mom_number')}}</b>: <strong class="badge badge-success text-lg">{{$mom_number}}</strong>
                    </h5>
                    <b>{{__('adminlte::moms.mom_type')}}:</b> {{$mom_arr['header']['type']}}
                    <br>
                    <b>{{__('adminlte::moms.agenda')}}:</b> <span class="font-weight-bold text-danger">{{$mom_arr['header']['agenda']}}</span>
                    <br>
                    <b>{{__('adminlte::moms.meeting_date')}}:</b> {{$mom_arr['header']['meeting_date']}}
                </div>
                <div class="card-body">
                    @foreach($mom_arr['topics'] as $value)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="callout callout-info topic-item">
                                    <h5><b>{{__('adminlte::moms.target_date')}}</b>: {{$value['target_date']}}</h5>
                                    <b>{{__('adminlte::moms.topic')}}:</b> {{$value['topic']}}
                                    <br>
                                    <b>{{__('adminlte::moms.next_step')}}:</b> {{$value['next_step']}}
                                    <br>
                                    <b>{{__('adminlte::moms.responsible')}}:</b> {{$value['responsible']}}
                                    <br>
                                    <b>{{__('adminlte::utilities.status')}}:</b> {{$value['status']}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
