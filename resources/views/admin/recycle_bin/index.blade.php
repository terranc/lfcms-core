@extends('admin.layouts.app')
@section('title', '回收站')
@section('js')
@endsection
@section('content')
    <div class="table-header">
        <form method="get" action="{{ regenUrl(['keyword_field', 'keyword_value'], null) }}" class="search-form">
            <div class="input-group">
                <input type='text' class="form-control" data-clear name="keyword_value" value="{{ $keyword_value }}" size="35" placeholder="请输入数据ID/标题/名称..." />
                <span class="input-group-btn">
                    <input type="hidden" name="keyword_field" value="object_id|name%%">
                    <button class="btn btn-default" type="submit">
                        <i class="icon ion-ios-search-strong md-18"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
    <form method="get">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th class="checkbox-col">
                    <input type="checkbox" v-check-all>
                </th>
                <th>数据ID</th>
                <th>标题/名称</th>
                <th>删除时间</th>
                <th>
                    操作
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists as $item)
                <tr>
                    <th class="checkbox-col" data-sort="{{ $item->id }}">
                        <input type="checkbox" name="id[]" value="{{ $item->id }}">
                    </th>
                    <td>{{ $item->object_id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="{{ route('recycle_bin.restore', $item->id) }}">还原</a>
                        <a href="{{ route('recycle_bin.destroy', $item->id) }}" v-delete>删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="table-footer">
            <div class="table-control">
                <span class="select">
                    <select name="action">
                        <option value="">批量操作</option>
                        <option value="restore">还原</option>
                        <option value="delete">删除</option>
                    </select>
                </span>
            </div>
        </div>
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

