<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $infos['titre'] }}</title>
        <meta name="description" content="{{ $infos['metaDesc']}}">

        @vite(['resources/css/app.css', 'resources/css/app.scss'])

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{asset('favicon-32x32.png')}}" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{asset('favicon-16x16.png')}}" sizes="16x16" />
    </head>
    <body id="home" class="{{ $infos['exist']}}">
        {!! $infos['contenueHTML'] !!}
    </body>
</html>
