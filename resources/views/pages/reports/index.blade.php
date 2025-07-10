@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::reports.reports'))
@section('content_header_title', __('adminlte::reports.reports'))
@section('content_header_subtitle', __('adminlte::reports.mom_reports'))

{{-- Content body: main page content --}}
@section('content_body')
    <div class="row">
        <div class="col-lg-12">
            <livewire:reports.filter/>
        </div>

        <div class="col-lg-12">
            <livewire:reports.status/>
        </div>

        <div class="col-lg-12">
            <livewire:reports.table/>
        </div>
    </div>
@stop

{{-- Push extra CSS --}}
@push('css')

@endpush

{{-- Push extra scripts --}}
@push('js')

@endpush
