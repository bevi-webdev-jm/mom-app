<div>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('adminlte::types.upload_types')}}</h4>
        </div>
        <div class="modal-body">
        
            <div class="row">
                <div class="col-lg-6">
                    <label for="file" class="mb-0">{{__('adminlte::utilities.upload_file')}}</label>
                    <input type="file" class="form-control form-control-sm{{$errors->has('file') ? ' is-invalid' : ''}}" id="file" wire:model="file">
                    <small class="text-danger">{{$errors->first('file')}}</small>
                </div>

                <div class="col-12 my-2">
                    <a href="{{asset('templates/TYPES TEMPLATE.xlsx')}}" class="text-primary">
                        <i class="fa fa-download mr-1"></i>
                        {{__('adminlte::utilities.download_template')}}
                    </a>
                </div>

                <div class="col-lg-12 mt-2">
                    <button class="btn btn-primary btn-xs" wire:click.prevent="checkFile" wire:loading.attr="disabled">
                        <i class="fa fa-check fa-sm" wire:loading.remove></i>
                        <i class="fa fa-spinner fa-spin fa-sm" wire:loading></i>
                        CHECK
                    </button>
                    
                </div>
            </div>

            @if(!empty($types_data))
                <strong wire:transition>{{__('adminlte::utilities.preview')}}</strong>
                <hr class="mt-0">
                <table class="table table-bordered table-sm" wire:transition>
                    <thead>
                        <tr>
                            <th>{{__('adminlte::types.type')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types_data as $type)
                            <tr>
                                <td>{{$type}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
        <div class="modal-footer text-right">
            @if(!empty($types_data))
                <button class="btn btn-primary" wire:click.prevent="saveTypes" wire:loading.attr="disabled">
                    <i class="fa fa-save"></i>
                    {{__('adminlte::utilities.upload')}}
                </button>
            @endif
            <button type="button" class="btn btn-default" data-dismiss="modal">
                {{__('adminlte::utilities.close')}}
            </button>
        </div>
    </div>
</div>
