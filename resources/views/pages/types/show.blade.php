@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::types.type_details'))
@section('content_header_title', __('adminlte::types.types'))
@section('content_header_subtitle', __('adminlte::types.type_details'))

{{-- Content body: main page content --}}
@section('content_body')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header py-2">
                <div class="row">
                    <div class="col-lg-6 align-middle">
                        <strong class="text-lg">{{__('adminlte::types.type_details')}}</strong>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a href="{{route('type.index')}}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-caret-left"></i>
                            {{__('adminlte::utilities.back')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>{{__('adminlte::types.type')}}:</strong>
                        {{$mom_type->type ?? '-'}}
                    </li>
                </ul>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-2">
                <div class="row">
                    <div class="col-lg-6 align-middle">
                        <strong class="text-lg">{{__('adminlte::moms.mom_list')}}</strong>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{ html()->form('GET', route('type.show', encrypt($mom_type->id)))->open() }}
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
                                    <th>{{__('adminlte::moms.mom_number')}}</th>
                                    <th>{{__('adminlte::types.type')}}</th>
                                    <th>{{__('adminlte::moms.agenda')}}</th>
                                    <th>{{__('adminlte::moms.meeting_date')}}</th>
                                    <th>{{__('adminlte::utilities.status')}}</th>
                                    <th>{{__('adminlte::users.user')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moms as $mom)
                                    <tr>
                                        <td class="align-middle text-center">
                                            {{$mom->mom_number}}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{$mom->type->type ?? '-'}}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{$mom->agenda ?? '-'}}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{$mom->meeting_date}}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-{{$status_arr[$mom->status]}} text-uppercase">
                                                {{$mom->status}}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{$mom->user->name}}
                                        </td>
                                        <td class="align-middle text-right p-0 pr-1">
                                            <a href="{{route('mom.show', encrypt($mom->id))}}" class="btn btn-info btn-xs mb-0 ml-0">
                                                <i class="fa fa-list"></i>
                                                {{__('adminlte::utilities.view')}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                {{$moms->links()}}
            </div>
        </div>
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