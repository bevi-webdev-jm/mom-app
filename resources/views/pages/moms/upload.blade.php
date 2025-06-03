@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::moms.upload_mom'))
@section('content_header_title', __('adminlte::moms.mom'))
@section('content_header_subtitle', __('adminlte::moms.upload_mom'))

{{-- Content body: main page content --}}
@section('content_body')
    <livewire:moms.upload/>
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
        });
    </script>
@endpush