    <!DOCTYPE html>
    <html lang="en">

    <head>
        @include('admin.layouts.head')
        @stack('style')
    </head>

    <body>
        @include('admin.layouts.header')
        <div class="slim-mainpanel">
            @yield('content')
        </div>
        @include('admin.layouts.footer')
        @include('admin.layouts.scripts')
        @stack('script')
    </body>

    </html>
