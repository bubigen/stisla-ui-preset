<!DOCTYPE html>
<html lang="en">
    @include('layouts.includes.head')
    <body>
        <div id="app">
            @yield('content')
        </div>
        @include('layouts.includes.scripts')
    </body>
</html>