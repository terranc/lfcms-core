@extends('admin.layouts.app')
@section('title', '分类管理')
@section('js')
@endsection
@section('nav-map')
    系统=
@endsection
@section('content')
    <div class="table-header">
        <div class="control-group">
            <a href="{{ route('category.create') }}" class="btn btn-primary">
                <i class="icon ion-plus"></i>
                添加
            </a>
        </div>
    </div>
    <form method="post">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th width="50">排序</th>
                <th width="30">ID</th>
                <th>分类名称</th>
                <th>标识</th>
                <th>类型</th>
                <th>描述</th>
                <th width="60" class="text-center">显示？</th>
                <th width="60" class="text-center">审核？</th>
                <th>
                    操作
                </th>
            </tr>
            </thead>
            <tbody>
                @each('admin.category._children', $lists, 'item')
            </tbody>
        </table>
    </form>
@endsection
@section('css')
    <link href="https://cdn.bootcss.com/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://cdn.bootcss.com/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
    <script>
    </script>
@endsection

