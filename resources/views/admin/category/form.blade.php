@extends('admin.layouts.app')
@section('title', $data ? '修改『' . $data->title . '』' : '添加')

@section('nav-map')
    系统=
    分类管理=admin/category
@endsection
@section('content')
    @component('admin.components.form-table', ['data'=>$data, 'model'=>'category'])
        @component('admin.components.form-item', ['label'=>'名称'])
            <input type="text" class="form-control" name="title" value="{{ $data->title }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'标识'])
            <input type="text" class="form-control" name="flag" value="{{ $data->flag }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'缩略图'])
            @if($data->thumb)
                <p>
                    <a href="{{ $data->thumb }}" target="_blank"><img src="{{ get_thumb_url($data->thumb, '160x160') }}"></a>
                </p>
            @endif
            <input type="file" name="thumb">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'类型'])
            <lf-options name="type" value="{{ $data->type ?? 'list' }}" :source="{{ json_encode($model->getTypeLists()) }}"></lf-options>
        @endcomponent
        @component('admin.components.form-item', ['label'=>'描述', 'class'=>'top'])
            <textarea class="form-control" name="description">{{ $data->description }}</textarea>
        @endcomponent
        @component('admin.components.form-item', ['label'=>'状态'])
            <lf-options name="status" value="{{ $data->status ?? 1 }}" :source="{{ json_encode($data->status_arr ?? $model->getStatusLists()) }}"></lf-options>
        @endcomponent
        @component('admin.components.form-item', ['label'=>'排序 ID'])
            <input type="number" class="form-control" name="sort_id" value="{{ $data->sort_id }}">
        @endcomponent
        @component('admin.components.form-item')
            <button class="btn btn-primary">保存</button>
            <a href="javascript: history.back()" class="btn btn-default">取消</a>
        @endcomponent
    @endcomponent
@endsection

@section('css')

@endsection
@section('js')
@endsection


