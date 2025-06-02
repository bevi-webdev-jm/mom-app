@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::moms.upload_mom'))
@section('content_header_title', __('adminlte::moms.mom'))
@section('content_header_subtitle', __('adminlte::moms.upload_mom'))

{{-- Content body: main page content --}}
@section('content_body')
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
            <livewire:moms.upload/>
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
        });
    </script>
@endpush