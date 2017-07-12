@extends('admin.layouts.app')
@section('title', $data ? '修改『' . $data->title . '』' : '添加')

@section('nav-map')
    系统=
    分类管理=admin/category
@endsection
@section('content')
    <ul class="nav nav-tabs">
        <li class="active"><a href="#basic" data-toggle="tab">基本</a></li>
        <li><a href="#advanced" data-toggle="tab">高级</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="basic">
            @component('admin.components.form-table', ['data'=>$data, 'model'=>'category'])
                @component('admin.components.form-item', ['label'=>'上级'])
                    <select class="form-control" name="parent_id">
                        <option value="0" {{ $data->parent_id === 0 ? 'selected' : '' }}>无上级（顶级分类）</option>
                        {!! app(App\Repositories\CategoryRepository::class)->makeTreeOption(0, $data->parent_id ?? request()->parent_id) !!}
                    </select>
                @endcomponent
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
                @component('admin.components.form-item', ['label'=>'是否显示？'])
                    <lf-options name="is_display" value="{{ $data->is_display ?? 1 }}" :source="{{ json_encode($model::DISPLAY) }}"></lf-options>
                @endcomponent
                @component('admin.components.form-item', ['label'=>'排序 ID'])
                    <input type="number" class="form-control" name="sort_id" value="{{ $data->sort_id ?? 1000 }}">
                @endcomponent
                @component('admin.components.form-item')
                    <button class="btn btn-primary">保存</button>
                    <a href="javascript: history.back()" class="btn btn-default">取消</a>
                @endcomponent
            @endcomponent
        </div>
        <div class="tab-pane" id="advanced">
            @component('admin.components.form-table', ['data'=>$data, 'model'=>'category'])
                @component('admin.components.form-item', ['label'=>'允许评论？'])
                    <lf-options name="is_comment" value="{{ $data->is_comment ?? 1 }}" :source="{{ json_encode($model::COMMENT) }}"></lf-options>
                @endcomponent
                @component('admin.components.form-item', ['label'=>'需要审核？'])
                    <lf-options name="is_check" value="{{ $data->is_check ?? 1 }}" :source="{{ json_encode($model::CHECK) }}"></lf-options>
                @endcomponent
                @component('admin.components.form-item', ['label'=>'前台列表模板'])
                    <input type="text" class="form-control" size="50" name="list_tpl" value="{{ $data->list_tpl }}" placeholder="如：document/index"> <em>留空默认为 <code>document/index</code></em>
                @endcomponent
                @component('admin.components.form-item', ['label'=>'前台详情模板'])
                    <input type="text" class="form-control" size="50" name="show_tpl" value="{{ $data->show_tpl }}" placeholder="如：document/index"> <em>留空默认为 <code>document/show</code></em>
                @endcomponent
                @component('admin.components.form-item', ['label'=>'扩展配置JSON', 'class'=>'top'])
                    <textarea class="form-control code-mirror" rows="6" name="meta">{{ $data->meta ? json_encode($data->meta) : '' }}</textarea>
                @endcomponent
                @component('admin.components.form-item')
                    <button class="btn btn-primary">保存</button>
                    <a href="javascript: history.back()" class="btn btn-default">取消</a>
                @endcomponent
            @endcomponent
        </div>
    </div>
@endsection

@section('css')

@endsection
@section('js')
    @include('admin.public.codemirror')
    <script>
        $(function(){
            $('a[data-toggle="tab"]').on('callback.bs.tab', function(e) {
                codeMirrorEditor('.code-mirror').each(function() {
                    this.editor.setValue(js_beautify(this.value));
                });
            });
        })
    </script>
@endsection


