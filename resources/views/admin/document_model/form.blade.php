@extends('admin.layouts.app')
@section('title', $data ? '修改『' . $data->title . '』' : '添加')

@section('nav-map')
    系统=
    模型管理=admin/document_model
@endsection
@section('content')
    @component('admin.components.form-table', ['data'=>$data, 'model'=>'document_model'])
        @component('admin.components.form-item', ['label'=>'名称'])
            <input type="text" class="form-control" name="title" value="{{ $data->title }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'标识'])
            <input type="text" class="form-control" name="name" value="{{ $data->name }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'状态'])
            <lf-options name="status" value="{{ $data->status ?? 1 }}" :source="{{ json_encode($data->status_arr ?? $model->getStatusLists()) }}"></lf-options>
        @endcomponent
        @component('admin.components.form-item')
            <button class="btn btn-primary">保存</button>
            <a href="javascript: history.back()" class="btn btn-default">取消</a>
        @endcomponent
    @endcomponent
@endsection

@section('js')
@endsection


