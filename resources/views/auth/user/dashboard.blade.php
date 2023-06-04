<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticketing System - My Dashboard</title>
    @include('cdn.bootstrap')
    @include('cdn.google-fonts')
    @include('cdn.popper-js')
    @include('cdn.bootstrap-icons')
    @include('cdn.sweetalert')
    @include('cdn.font-awesome')
    @include('cdn.datatable-button')
</head>

<body>
    @include('partials.sidebar')

    @include('cdn.moment')
    @include('cdn.bootstrap-datatable')
</body>

</html>
