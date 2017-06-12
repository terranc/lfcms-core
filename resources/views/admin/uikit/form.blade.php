@extends('admin.layouts.app')
@section('title', $user ? '修改『' . $user->name . '』' : '添加')

@section('nav-map')
    用户=
    用户管理=admin/uikit
@endsection
@section('content')
    @component('admin.components.form-table', ['data'=>$user, 'model'=>'uikit', 'class'=>'custom-form-class'])
        @component('admin.components.form-item', ['label'=>'名字'])
            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'邮箱'])
            <input type="text" class="form-control" size="40" name="email" value="{{ $user->email }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'密码'])
            <input type="password" class="form-control" name="password" placeholder="不修改请留空">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'确认密码'])
            <input type="password" class="form-control" name="password_confirmation" placeholder="再次确认密码">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'生日'])
            <input type="text" class="form-control" name="birthday" value="{{ $user->birthday }}" v-datepicker>
        @endcomponent
        @component('admin.components.form-item', ['label'=>'开卡时间'])
            <input type="text" class="form-control" name="open_card_time" value="{{ $user->open_card_time }}" data-format="YYYY-MM-DD HH:mm:ss" v-datepicker>
        @endcomponent
        @component('admin.components.form-item', ['label'=>'状态'])
            <lf-options name="status" value="{{ $user->status }}" :source="{{ json_encode($user->status_arr) }}"></lf-options>
        @endcomponent
        @component('admin.components.form-item', ['label'=>'注册时间'])
            {{ $user->created_at ?: '-' }}
        @endcomponent
        @component('admin.components.form-item')
            <button class="btn btn-primary">保存</button>
            <a href="javascript: history.back()" class="btn btn-default">取消</a>
        @endcomponent
    @endcomponent
@endsection

@section('js')
@endsection


