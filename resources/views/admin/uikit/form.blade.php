@extends('admin.layouts.app')
@section('title', $data ? '修改『' . $data->nickname . '』' : '添加')

@section('nav-map')
    用户=
    用户管理=admin/uikit
@endsection
@section('content')
    @component('admin.components.form-table', ['data'=>$data, 'model'=>'uikit'])
        @component('admin.components.form-item', ['label'=>'用户名'])
            <input type="text" class="form-control" name="username" value="{{ $data->username }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'昵称'])
            <input type="text" class="form-control" name="nickname" value="{{ $data->nickname }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'邮箱'])
            <input type="text" class="form-control" size="40" name="email" value="{{ $data->email }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'密码'])
            <input type="password" class="form-control" name="password" placeholder="不修改请留空">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'确认密码'])
            <input type="password" class="form-control" name="password_confirmation" placeholder="再次确认密码">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'状态'])
            <lf-options name="status" value="{{ $data->status ?? 1 }}" :source="{{ json_encode($data->status_arr ?? $model->getStatusLists()) }}"></lf-options>
        @endcomponent
        @component('admin.components.form-item', ['label'=>'注册时间'])
            {{ $data->created_at ?: '-' }}
        @endcomponent
        @component('admin.components.form-item')
            <button class="btn btn-primary">保存</button>
            <a href="javascript: history.back()" class="btn btn-default">取消</a>
        @endcomponent
    @endcomponent
@endsection

@section('js')
@endsection


