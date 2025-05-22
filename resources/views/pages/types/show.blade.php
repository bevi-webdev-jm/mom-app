@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::types.type_list'))
@section('content_header_title', __('adminlte::types.types'))
@section('content_header_subtitle', __('adminlte::types.type_list'))

{{-- Content body: main page content --}}
@section('content_body')
    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-lg-6 align-middle">
                    <strong class="text-lg">{{__('adminlte::types.type_list')}}</strong>
                </div>
            </div>
        </div>
        <div class="card-body">

        </div>
        <div class="card-footer">
        </div>
    </div>
@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        $(function() {
            $('body').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                Livewire.dispatch('setDeleteModel', {type: 'MomType', model_id: id});
                $('#modal-delete').modal('show');
            });
        });
    </script>
@endpush