<div>
    <div class="card">
        <div class="card-header row">
            <div class="col-lg-6 align-middle">
                <strong class="text-lg">{{__('adminlte::moms.remarks')}}</strong>
            </div>
            <div class="col-lg-6 text-right">
                @if(!$switch)
                    <button class="btn btn-success btn-sm" wire:click.prevent="switchEdit" wire:loading.attr="disabled">
                        <i class="fa fa-pen-alt mr-1"></i>
                        {{__('adminlte::utilities.edit')}}
                    </button>
                @endif
            </div>
        </div>
        <div class="card-body p-1">
            @if($switch)
                <textarea class="form-control form-control-sm" wire:model="remarks" placeholder="{{__('adminlte::moms.remarks_placeholder')}}"></textarea>
            @else
                <p class="mb-0 p-2">{{$remarks}}</p>
            @endif
        </div>
        <div class="card-footer text-right">
            @if($switch)
                <button class="btn btn-primary btn-sm" wire:click.prevent="saveRemarks" wire:loading.attr="disabled">
                    <i class="fa fa-save mr-1"></i>
                    {{__('adminlte::utilities.save')}}
                </button>
                <button class="btn btn-secondary btn-sm" wire:click.prevent="switchEdit" wire:loading.attr="disabled">
                    <i class="fa fa-ban mr-1"></i>
                    {{__('adminlte::utilities.cancel')}}
                </button>
            @endif
        </div>
    </div>
</div>
