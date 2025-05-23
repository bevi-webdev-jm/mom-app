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
                <div class="col-lg-6 text-right">
                    @can('type create')
                        <a href="{{route('type.create')}}" class="btn btn-primary btn-xs">
                            <i class="fa fa-file"></i>
                            {{__('adminlte::types.new_type')}}
                        </a>
                    @endcan
                    @can('type upload')
                        <a href="" class="btn btn-success btn-xs" id="btn-upload">
                            <i class="fa fa-upload"></i>
                            {{__('adminlte::utilities.upload')}}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">

            {{ html()->form('GET', route('type.index'))->open() }}
                <div class="row mb-1">
                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ html()->label(__('adminlte::utilities.search'), 'search')->class('mb-0') }}
                            {{ html()->input('text', 'search', $search)->placeholder(__('adminlte::utilities.name'))->class(['form-control', 'form-control-sm'])}}
                        </div>
                    </div>
                </div>
            {{ html()->form()->close() }}
            
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-sm table-striped table-hover mb-0 rounded">
                        <thead class="tex-center bg-dark">
                            <tr class="text-center">
                                <th>{{__('adminlte::types.type')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($types as $type)
                                <tr>
                                    <td class="align-middle text-center">
                                        {{$type->type}}
                                    </td>
                                    <td class="align-middle text-right p-0 pr-1">
                                        <a href="{{route('type.show', encrypt($type->id))}}" class="btn btn-info btn-xs mb-0 ml-0">
                                            <i class="fa fa-list"></i>
                                            {{__('adminlte::utilities.view')}}
                                        </a>
                                        @can('type edit')
                                            <a href="{{route('type.edit', encrypt($type->id))}}" class="btn btn-success btn-xs mb-0 ml-0">
                                                <i class="fa fa-pen-alt"></i>
                                                {{__('adminlte::utilities.edit')}}
                                            </a>
                                        @endcan
                                        @can('type delete')
                                            <a href="" class="btn btn-danger btn-xs mb-0 ml-0 btn-delete" data-id="{{encrypt($type->id)}}">
                                                <i class="fa fa-trash-alt"></i>
                                                {{__('adminlte::utilities.delete')}}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="card-footer">
            {{ $types->links() }}
        </div>
    </div>

    <div class="modal fade" id="type-upload-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <livewire:types.upload/>
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
    @can('type upload')
        <script>
            $(function() {
                $('#btn-upload').click(function(e) {
                    e.preventDefault();
                    $('#type-upload-modal').modal('show');
                });
            });
        </script>
    @endcan
@endpush