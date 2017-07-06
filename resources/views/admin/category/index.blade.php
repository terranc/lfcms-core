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
                <th>排序</th>
                <th>ID</th>
                <th>分类名称</th>
                <th>标识</th>
                <th>类型</th>
                <th>描述</th>
                <th>显示？</th>
                <th>审核？</th>
                <th>
                    操作
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists as $item)
                <tr>
                    <td data-name="sort_id" data-pk="{{ $item->id }}" v-ajax-edit>{{ $item->sort_id }}</td>
                    <td>{{ $item->id }}</td>
                    <td data-name="title" data-pk="{{ $item->id }}" v-ajax-edit>{{ $item->title }}</td>
                    <td data-name="flag" data-pk="{{ $item->id }}" v-ajax-edit>{{ $item->flag }}</td>
                    <td data-value="{{ $item->type }}" data-name="type" data-pk="{{ $item->id }}" data-options="{{ http_build_query($item->getTypeLists()) }}" v-ajax-edit>{{ $item->type_text }}</td>
                    <td data-name="description" data-type="textarea" data-pk="{{ $item->id }}" v-ajax-edit>{{ $item->description }}</td>
                    <td>{{ $item->is_display }}</td>
                    <td>{{ $item->is_check }}</td>
                    <td>
                        <a href="{{ route('category.edit', $item->id) }}">编辑</a>
                        <a href="{{ route('category.destroy', $item->id) }}" v-delete>删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
    <div class="pagination-box">
        <div>
            共有 {{ $lists->total() }} 条记录
        </div>
        <div>
            {{ $lists->withPath(regenUrl())->links() }}
            <div class="page-control">
                <form action="{{ regenUrl() }}" method="get">
                    <input class="form-control" min="1" max="{{ $lists->lastPage() }}" name="page" type="number" value="{{ $lists->currentPage() }}"> / {{ $lists->lastPage() }} 页
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://cdn.bootcss.com/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://cdn.bootcss.com/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
    <script>
    </script>
@endsection

