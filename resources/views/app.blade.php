<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('/css/general-styles.css') }}" rel="stylesheet" />
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ mix('/js/app.js') }}" defer></script>

        @inertiaHead
        @routes

    </head>
    <body>
        @inertia

        <script src="{{ asset('/js/general-scripts.js') }}" charset="utf-8"></script>
    </body>
</html>
