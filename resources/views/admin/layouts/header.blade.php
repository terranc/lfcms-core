<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','首页')</title>
    <link rel="stylesheet" href="//unpkg.com/vue-beauty/package/style/vue-beauty.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/nprogress/0.2.0/nprogress.min.css">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @yield('css')
</head>
<body>
