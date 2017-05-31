@extends('admin.layouts.frame')
@section('title', 'UI kit')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/frame.css') }}">
@endsection
@section('js')
    <script>
        window.app.menu.data = [{
            name: '用户',
            icon: 'user',
            children: [{
                name: '用户管理',
                href: '#/uikit/table'
            }, {
                name: '添加用户',
                href: '#/uikit/form'
            }],
        }, {
            name: '内容',
            icon: 'file-text',
            children: [{
                name: 'Team1'
            }, {
                name: '三级导航',
                icon: 'file-text',
                children: [{
                    name: '选项7',
                    icon: 'file-text',
                    href: '#/uikit/form'
                }, {
                    name: '选项8',
                    href: '#/uikit/form'
                }]
            }]
        }, {
            name: '系统',
            icon: 'setting',
            href: '#/uikit/form'
        }];
    </script>
@endsection
