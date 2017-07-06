@extends('admin.layouts.app')
@section('title', '模型管理')
@section('js')
@endsection
@section('nav-map')
    系统=
@endsection
@section('content')
    <div class="table-header">
        <div class="control-group">
            <a href="{{ route('document_model.create') }}" class="btn btn-primary">
                <i class="icon ion-plus"></i>
                添加
            </a>
        </div>
    </div>
    <form method="post">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>模型名字</th>
                <th>标识</th>
                <th>状态</th>
                <th>
                    操作
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists as $item)
                <tr>
                    <td data-name="title" data-pk="{{ $item->id }}" v-ajax-edit>{{ $item->title }}</td>
                    <td data-name="name" data-pk="{{ $item->id }}" v-ajax-edit>{{ $item->name }}</td>
                    <td data-value="{{ $item->status }}" data-name="status" data-pk="{{ $item->id }}" data-options="{{ http_build_query($item->getStatusLists()) }}" v-ajax-edit>{{ $item->status_text }}</td>
                    <td>
                        <a href="{{ route('document_model.edit', $item->id) }}">编辑</a>
                        <a href="{{ route('document_model.destroy', $item->id) }}" v-delete>删除</a>
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

@section('js')
    <script>
    </script>
@endsection

