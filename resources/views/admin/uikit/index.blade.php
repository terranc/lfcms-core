@extends('admin.layouts.app')
@section('title', 'Bootstrap')
@section('js')
@endsection
@section('nav-map')
UI Kit=
@endsection
@section('content')
    <div class="demo-box"><a href="{{ url('admin/uikit', ['id'=>38]) }}" v-delete="{ target: '.demo-box' }">删除</a></div>
    <div class="demo-box"><a href="http://baidu.com" v-modal-open>打开浮层</a></div>
    <div class="demo-box"><a href="http://baidu.com"  v-tooltip title="打开百度">Tooltip</a></div>
    <form action="{{ url('admin/uikit', ['id'=>3]) }}" class="demo-box" v-delete>
        <button class="btn btn-primary">表单提交删除</button>
    </form>
    <form action="{{ url('admin/uikit', ['id'=>3]) }}" class="demo-box" v-confirm="{method: 'delete'}">
        <button class="btn btn-primary">表单提交二次确认</button>
    </form>
    <p>{{ regenUrl(['a', 'b', 'c'], null) }}</p>
    <p>{{ regenUrl(['a', 'b', 'c'], [1, 2, null]) }}</p>
    <form class="filter-box" action="{{ regenUrl('') }}">
        <dl>
            <dt>类型</dt>
            <dd>
                <a href="{{ regenUrl('filter_type', null) }}" class="item selected">全部</a>
                <a href="{{ regenUrl('filter_type', 1) }}" class="item">类型1</a>
                <a href="{{ regenUrl('filter_type', 2) }}" class="item">类型2</a>
                <a href="{{ regenUrl('filter_type', 3) }}" class="item">类型3</a>
                <a href="{{ regenUrl('filter_type', 1) }}" class="item">类型1</a>
                <a href="{{ regenUrl('filter_type', 2) }}" class="item">类型2</a>
                <a href="{{ regenUrl('filter_type', 3) }}" class="item">类型3</a>
            </dd>
        </dl>
        <dl>
            <dt>操作员</dt>
            <dd>
                <input type="text" class="form-control" placeholder="请输入操作员姓名...">
            </dd>
        </dl>
        <dl>
            <dt>分类</dt>
            <dd>
                <!--
                name: 带搜索下拉框
                directive: v-select="{}" （select2配置项，见文档：https://select2.github.io/options.html）
                    data-selected: 默认选中值
                -->
                <select class="form-control" name="filter_classname" v-select data-selected="3">
                    <option>请选择分类..</option>
                    <option value="1">分类1分类1分类1分类1分类1分类1分类1分类1</option>
                    <option value="2">分类2</option>
                    <option value="3">分类3</option>
                    <option value="4">分类4</option>
                    <option value="5">分类5</option>
                    <option value="6">分类6</option>
                    <option value="7">分类7</option>
                    <option value="8">分类8</option>
                    <option value="9">分类9</option>
                </select>
            </dd>
        </dl>
        <dl>
            <dt>注册时间</dt>
            <dd>
                <!--
                name: 时间选择器
                attributes:
                    fist-name: 开始时间控件 name（必填）
                    second-name: 结束时间控件 name
                    first-value: 开始时间默认值
                    end-value: 结束时间默认值
                    format: 格式，默认：YYYY-MM-DD
                    required: 是否必填
                    first-option: 开始时间配置
                    end-option: 开始时间配置
                -->
                <lf-datepicker first-name="filter_start_created_at"></lf-datepicker>
            </dd>
        </dl>
        <dl>
            <dt>注册时间</dt>
            <dd>
                <lf-datepicker first-name="filter_start_created_at" second-name="filter_end_created_at" first-value="{{ date('Y-m-d H:i') }}" format="YYYY-MM-DD HH:mm" required :first-option="{ minDate: '{{ date('Y-m-d H:i') }}' }"></lf-datepicker>
            </dd>
        </dl>
        <dl class="filter-submit">
            <dd>
                <button type="submit" class="btn btn-primary">筛选</button>
                <button type="reset" class="btn btn-default">重置</button>
            </dd>
        </dl>
    </form>
    <div class="table-header">
        <div class="control-group">
            <a href="{{ route('uikit.create') }}" class="btn btn-primary">
                <i class="icon ion-plus"></i>
                添加
            </a>
            <a href="{{ regenUrl('action', 'export') }}" class="btn btn-default">导出</a>
        </div>
        <form method="get" action="{{ regenUrl(['keyword_field', 'keyword_value'], null) }}" class="search-form">
            <div class="input-group">
                <input type='text' class="form-control" name="keyword_value" value="" size="35" placeholder="请输入关键词..." />
                <span class="input-group-btn">
                    <input type="hidden" name="keyword_field" value="">
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
                <th class="checkbox-col">
                    <input type="checkbox" v-check-all>
                </th>
                <th data-sort-field="name">名字</th>
                <th>邮箱</th>
                <th data-sort-field="created_at">创建时间</th>
                <th>状态</th>
                <th>
                    操作
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <th class="checkbox-col" data-sort="{{ $user->id }}">
                    <input type="checkbox" name="id[]" value="{{ $user->id }}">
                </th>
                <td data-type="text" data-name="name" data-pk="{{ $user->id }}" v-ajax-edit>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                <td data-value="{{ $user->status }}" data-name="status" data-pk="{{ $user->id }}" data-select="{{ http_build_query($user->status_arr) }}" v-ajax-edit>{{ $user->status_text }}</td>
                <td>
                    <a href="{{ route('uikit.edit', $user->id) }}">编辑</a>
                    <a href="{{ route('uikit.destroy', $user->id) }}" v-delete>删除</a>
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
                        <option value="enable">启用</option>
                        <option value="disable">禁用</option>
                        <option value="delete">删除</option>
                    </select>
                </span>
                <span class="text-muted">注：请注意</span>
            </div>
            <ul class="data-stat">
                <li>汇总金额<var>￥1000.00</var></li>
                <li>总人数<var>300</var></li>
            </ul>
        </div>
    </form>
    <div class="pagination-box">
        <div>
            共有 {{ $users->total() }} 条记录
        </div>
        <div>
            {{ $users->withPath(regenUrl())->links() }}
            <div class="page-control">
                <form action="{{ regenUrl() }}" method="get">
                    <input class="form-control" min="1" max="{{ $users->lastPage() }}" name="page" type="number" value="{{ $users->currentPage() }}"> / {{ $users->lastPage() }} 页
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
    </script>
@endsection

