@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::moms.topic'))
@section('content_header_title', __('adminlte::moms.mom'))
@section('content_header_subtitle', __('adminlte::moms.topic'))

{{-- Content body: main page content --}}
@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <strong class="text-lg">{{__('adminlte::moms.mom_number')}}: {{$detail->mom->mom_number}}</strong>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a href="{{route('mom.show', encrypt($detail->mom_id))}}" class="btn btn-secondary btn-sm">
                                {{__('adminlte::utilities.back')}}
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <livewire:moms.topics.item :detail="$detail" :responsibles="$detail->mom->participants" type="show" :key="$detail->id"/>
        </div>
    </div>

    
    
@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        $(function() {
        });
    </script>
@endpush