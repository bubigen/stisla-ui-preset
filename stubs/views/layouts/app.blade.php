<!DOCTYPE html>
<html lang="en">
    @include('layouts.includes.head')
    <body>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
                @include('layouts.includes.topbar')
                @include('layouts.includes.sidebar')
                <!-- Main Content -->
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('layouts.includes.scripts')
    </body>
</html>