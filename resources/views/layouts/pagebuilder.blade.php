<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">

        <title>{{config('app.name')}}</title>

        @vite(['resources/css/app.css', 'resources/css/app.scss'])
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{asset('favicon-32x32.png')}}" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{asset('favicon-16x16.png')}}" sizes="16x16" />
    </head>
    <body id="pagebuilder">
        @yield('content')

        @yield('script')
        @vite(['public/js/page-builder/page-builder.js'])
    </body>
</html>
