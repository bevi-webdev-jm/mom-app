@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', __('adminlte::adminlte.welcome'))
@section('content_header_title', __('adminlte::adminlte.home'))
@section('content_header_subtitle', __('adminlte::adminlte.welcome'))

{{-- Content body: main page content --}}

@section('content_body')
    <div class="hero-section card p-4 shadow-sm">
        <h2 class="welcome-message">Welcome to the Minutes of Meeting System</h2>
        <p class="intro-text">
            This system helps you efficiently record meeting minutes, manage tasks assigned during meetings, and receive timely notifications about your responsibilities.
            Stay organized and never miss an important update or deadline.
        </p>

        <div class="additional-info mt-4">
            <h4>Key Features</h4>
            <ul class="info-list text-left mx-auto" style="max-width: 500px;">
                <li>Accurate recording and archiving of meeting minutes.</li>
                <li>Task management with clear assignment and tracking.</li>
                <li>Automated notifications to users about their tasks and deadlines.</li>
                <li>Easy access to past meetings and task statuses.</li>
            </ul>
        </div>

        <div class="logo-container mt-4 text-center">
            <img src="{{asset('images/mom-logo2.png')}}" alt="logo" class="logo-img">
        </div>
    </div>

    <a href="{{route('test-notification')}}" class="btn btn-primary btn-sm test-notification-btn">
        {{ __('adminlte::adminlte.test_notification') }}
    </a>
@stop

{{-- Push extra CSS --}}

@push('css')
    <style>
        .hero-section {
            background-color: #fff8f0;
            border-radius: 8px;
            max-width: 700px;
            margin: 2rem auto;
            text-align: center;
        }
        .welcome-message {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #6c757d;
        }
        .intro-text {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: #495057;
        }
        .test-notification-btn {
            margin-bottom: 1.5rem;
        }
        .logo-img {
            max-height: 400px;
            width: auto;
            display: inline-block;
        }
    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
@endpush
