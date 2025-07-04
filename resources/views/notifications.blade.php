@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Notifications')
@section('content_header_title', 'Notifications')
@section('content_header_subtitle', 'List')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="card">
        <div class="card-header py-2">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-bell mr-1"></i>
                    <strong>NOTIFICATION LIST</strong>
                </h3>
            </div>
        </div>
        <div class="card-body">

            {{ html()->form('GET', route('notifications'))->open() }}
                <div class="row mb-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group">
                            {{ html()->input('text', 'search', $search)->placeholder('Search notifications...')->class(['form-control form-control-sm'])}}
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-sm btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            {{ html()->form()->close() }}
            
            @if($notifications->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle mr-1"></i> You have no new notifications.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover bg-white mb-0 rounded">
                        <thead class="thead-light text-center">
                            <tr class="text-center">
                                <th style="width: 5%;" class="text-center">STATUS</th>
                                <th style="width: 25%;" class="text-left">TITLE</th>
                                <th style="width: 45%;" class="text-left">MESSAGE</th>
                                <th style="width: 15%;">RECEIVED</th>
                                <th style="width: 10%;">ACTIONS</th>
                            </tr>
                        </thead>magic_quotes_runtime














































































































































































































































































































































































































                        
                        <tbody>
                            @foreach($notifications as $notification)
                                <tr class="{{ empty($notification->read_at) ? 'font-weight-bold' : '' }}">
                                    <td class="text-center align-middle">
                                        @if(empty($notification->read_at))
                                            <span class="badge badge-danger">Unread</span>
                                        @else
                                            <span class="badge badge-success">Read</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-left">
                                        {{ Str::limit($notification->data['title'] ?? 'N/A', 50) }}
                                    </td>
                                    <td class="align-middle text-left">
                                        {{ Str::limit($notification->data['message'] ?? 'No message content.', 100) }}
                                    </td>
                                    <td class="text-center align-middle" title="{{ $notification->created_at->format('F j, Y g:i A') }}">
                                        {{$notification->created_at->diffForHumans()}}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{$notification->data['action_url'] ?? '#'}}" class="btn btn-xs btn-primary" title="View Details">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @php
                                    // Mark as read when displayed, if not already read
                                    if(empty($notification->read_at)) {
                                        $notification->markAsRead();
                                    }
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
        <div class="card-footer">
            {{$notifications->links()}}
        </div>
    </div>
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    <style>
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
@endpush