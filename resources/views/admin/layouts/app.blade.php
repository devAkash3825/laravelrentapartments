    <!DOCTYPE html>
    <html lang="en">

    <head>
        @include('admin.layouts.head')
        @stack('style')
    </head>

    <body>
        @include('admin.layouts.header')
        <div class="slim-mainpanel">
            <div class="container">
                @yield('content')
            </div>
        </div>
        @include('admin.layouts.footer')
        @include('admin.layouts.scripts')
        @stack('script')
    </body>

    </html>