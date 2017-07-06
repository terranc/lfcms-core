@extends('admin.layouts.app')
@section('title', '系统配置')
@section('js')
@endsection
@section('nav-map')
    系统=
@endsection
@section('content')
    <form class="filter-box" action="{{ regenUrl('') }}">
        <dl>
            <dt>命名空间</dt>
            <dd>
                <a href="{{ regenUrl('filter_namespace', null) }}" class="item" :class=" '' === '{{ $filtrate->namespace }}' ? 'selected' : ''">不限</a>
                @foreach($namespace_lists as $item)
                    <a href="{{ regenUrl('filter_namespace', $item) }}" class="item" :class=" '{{ $item }}' === '{{ $filtrate->namespace }}' ? 'selected' : ''">{{ $item }}</a>
                @endforeach
            </dd>
        </dl>
    </form>
    <div class="table-header">
        <div class="control-group">
            <a href="{{ route('config.create') }}" class="btn btn-primary">
                <i class="icon ion-plus"></i>
                添加
            </a>
        </div>
        <form method="get" action="{{ regenUrl(['keyword_field', 'keyword_value'], null) }}" class="search-form">
            <div class="input-group">
                <input type='text' class="form-control" data-clear name="keyword_value" value="{{ $keyword_value }}" size="35" placeholder="请输入命名空间/配置名称/配置说明..." />
                <span class="input-group-btn">
                    <input type="hidden" name="keyword_field" value="namespace|name|remark%%">
                    <button class="btn btn-default" type="submit">
                        <i class="icon ion-ios-search-strong md-18"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
    <form method="post">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>命名空间</th>
                <th>配置名称</th>
                <th>配置说明</th>
                <th>类型</th>
                <th>配置值</th>
                <th>
                    操作
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists as $item)
                <tr>
                    <td>{{ $item->namespace }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->remark ?? '-' }}</td>
                    <td>{{ $item->type_text }}</td>
                    <td>{!! nl2br(str_limit($item->value_original, 80)) !!}</td>
                    <td>
                        <a href="{{ route('config.edit', $item->id) }}">编辑</a>
                        <a href="{{ route('config.destroy', $item->id) }}" v-delete>删除</a>
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

