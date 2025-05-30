@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

{{-- Default Content Wrapper --}}
<div class="{{ $layoutHelper->makeContentWrapperClasses() }}">

    {{-- Preloader Animation (cwrapper mode) --}}
    @if($preloaderHelper->isPreloaderEnabled('cwrapper'))
        @include('adminlte::partials.common.preloader')
    @endif

    {{-- Content Header --}}
    @hasSection('content_header')
        <div class="content-header">
            <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                @yield('content_header')
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <div class="content">
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
            
            {{-- SUCCESS MESSAGE --}}
            @if(session()->has('message_success'))
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-check mr-1"></i> Success!
                    <br>
                    {{session('message_success')}}
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if(session()->has('message_error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation mr-1"></i> Error!
                    <br>
                    {{session('message_error')}}
                </div>
            @endif

            @stack('content')
            @yield('content')
        </div>
    </div>

</div>
