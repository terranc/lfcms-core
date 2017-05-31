@extends('admin.layouts.app')
@section('title', '用户管理')

@section('nav-map')
    用户=
@endsection
@section('content')
    <v-more-panel>
        <v-form slot="form">
            <v-form-item label="用户名">
                <v-input name="username" placeholder="请输入用户名"></v-input>
            </v-form-item>
            <v-form-item label="机构编码">
                <v-input placeholder="请输入机构编码"></v-input>
            </v-form-item>
            <v-form-item label="机构编码">
                <v-input placeholder="请输入机构编码"></v-input>
            </v-form-item>
            <v-form-item label="机构编码">
                <v-input placeholder="请输入机构编码"></v-input>
            </v-form-item>
            <v-form-item label="机构编码">
                <v-input placeholder="请输入机构编码"></v-input>
            </v-form-item>
            <v-form-item label="年龄">
                <v-input placeholder="请输入年龄"></v-input>
            </v-form-item>
            <v-form-item label="手机">
                <v-input placeholder="请输入手机号码"></v-input>
            </v-form-item>
        </v-form>
        <v-button slot="control" type="primary" html-type="button" icon="search">查询</v-button>
    </v-more-panel>
    <div :style="{ 'background-color': '#000', 'padding': '20px', 'margin': '10px 0'}"><a href="{{ url('admin/uikit/delete', ['id'=>3]) }}" v-delete:div>删除</a></div>
    <div :style="{ 'background-color': '#000', 'padding': '20px', 'margin': '10px 0'}"><a href="{{ url('admin/uikit/delete', ['id'=>3]) }}" v-confirm:div="{title:'确认要更新吗？'}">更新</a></div>
    <div :style="{ 'background-color': '#000', 'padding': '20px', 'margin': '10px 0'}"><a href="{{ url('admin/uikit/table') }}" v-modal-open>打开</a></div>
    <form action="{{ url('admin/uikit/delete', ['id'=>3]) }}" v-delete>
        <button>删除</button>
    </form>
    <form action="{{ url('admin/uikit/delete', ['id'=>3]) }}" v-confirm="{method: 'delete'}">
        {{ csrf_field() }}
        <button>提交</button>
    </form>
    <form>
        <v-data-table :data="listData" :columns="list.columns" :response-params-name="{ total: 'total', results: 'items' }">
        </v-data-table>
        <div class="table-control">
            <select class="form-control">
                <option value="">请选择 ...</option>
                <option value="1">批量审核</option>
                <option value="2">批量删除</option>
            </select>
            <button class="btn btn-primary">全部结算</button>
            <span class="text-muted">注：请注意</span>
        </div>
    </form>
    <div class="data-stat"><span>汇总金额：<var>￥1000.00</var></span><span>总人数：<var>300</var></span></div>
    {{ $users->links('vendor.pagination.vue') }}
@endsection

@section('js')
    <script>
        window.app.list.total = 50;
        window.app.list.columns = [{
            title: '姓名',
            field: 'name',
        }, {
            title: '邮箱',
            field: 'email',
        }, {
            title: '注册时间',
            field: 'created_at',
            sort: true,
        }];
    </script>
@endsection


