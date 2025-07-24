@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::locations.new_location'))
@section('content_header_title', __('adminlte::locations.locations'))
@section('content_header_subtitle', __('adminlte::locations.new_location'))

{{-- Content body: main page content --}}
@section('content_body')
    {{ html()->form('POST', route('location.store'))->open() }}

        <div class="card">
            <div class="card-header py-2">
                <div class="row">
                    <div class="col-lg-6 align-middle">
                        <strong class="text-lg">{{__('adminlte::locations.new_location')}}</strong>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a href="{{route('location.index')}}" class="btn btn-secondary btn-xs">
                            <i class="fa fa-caret-left"></i>
                            {{__('adminlte::utilities.back')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    
                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ html()->label(__('adminlte::locations.location_name'), 'location_name')->class(['mb-0']) }}
                            {{ 
                                html()->text('location_name', '')
                                ->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('location_name')])
                                ->placeholder(__('adminlte::locations.location_name'))
                            }}
                            <small class="text-danger">{{$errors->first('location_name')}}</small>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ html()->label(__('adminlte::locations.address'), 'address')->class(['mb-0']) }}
                            {{ 
                                html()->text('address', '')
                                ->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('address')])
                                ->placeholder(__('adminlte::locations.address'))
                            }}
                            <small class="text-danger">{{$errors->first('address')}}</small>
                        </div>
                    </div>

                </div>

            </div>
            <div class="card-footer text-right">
                {{ html()->submit('<i class="fa fa-save"></i> '.__('adminlte::locations.save_location'))->class(['btn', 'btn-primary', 'btn-sm']) }}
            </div>
        </div>

    {{ html()->form()->close() }}
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