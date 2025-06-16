@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::fire-alarms.emergency_alarm'))
@section('content_header_title', __('adminlte::fire-alarms.emergency_alarm'))
@section('content_header_subtitle', __('adminlte::fire-alarms.emergency_alarm'))

{{-- Content body: main page content --}}
@section('content_body')
    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-lg-6 align-middle">
                    <strong class="text-lg">{{__('adminlte::fire-alarms.fire_alarm')}}</strong>
                </div>
                <div class="col-lg-6 text-right">
                </div>
            </div>
        </div>
        <div class="card-body">
            <livewire:fire-alarm.alarm :sound="asset('sounds/Emergency Alarm Rev3.mp3')" title="Fire Alarm"/>
        </div>
        <div class="card-footer">
        </div>
    </div>

    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-lg-6 align-middle">
                    <strong class="text-lg">{{__('adminlte::fire-alarms.emergency_alarm')}}</strong>
                </div>
                <div class="col-lg-6 text-right">
                </div>
            </div>
        </div>
        <div class="card-body">
            <livewire:fire-alarm.alarm :sound="asset('sounds/Firealarm Rev1.mp3')" title="Emergency Alarm"/>
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
                Livewire.dispatch('setDeleteModel', {type: 'Mom', model_id: id});
                $('#modal-delete').modal('show');
            });
        });
    </script>
@endpush