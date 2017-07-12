@extends('admin.layouts.app')
@section('title', $data ? '修改『' . $data->namespace . '.' . $data->name . '』' : '添加')

@section('nav-map')
    系统=
    系统配置=admin/config
@endsection
@section('content')
    @component('admin.components.form-table', ['data'=>$data, 'model'=>'config'])
        @component('admin.components.form-item', ['label'=>'命名空间'])
            <input type="text" class="form-control" name="namespace" value="{{ $data->namespace }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'配置名称'])
            <input type="text" class="form-control" name="name" value="{{ $data->name }}">
        @endcomponent
        @component('admin.components.form-item', ['label'=>'配置说明', 'class' => 'top'])
            <textarea class="form-control" name="remark" rows="2" cols="80">{{ $data->remark }}</textarea>
        @endcomponent
        @component('admin.components.form-item', ['label'=>'类型'])
            <lf-options name="type" value="{{ $data->type ?? 1 }}" :source="{{ json_encode($model->getTypeListsText()) }}"></lf-options>
        @endcomponent
        @component('admin.components.form-item', ['label'=>'配置值', 'class' => 'top'])
            <p><textarea class="form-control code-mirror" name="value" rows="12" cols="80">{{ $data->value_original }}</textarea></p>
            <blockquote class="readme">
                <p>
                    <strong>文本：</strong><br />
                    长沙鹿可非尔网络科技有限公司
                </p>
                <p>
                    <strong>枚举（星号代表默认项）：</strong><br />
                    配置值A*<br />
                    配置值B
                </p>
                <p>
                    <strong>数组（键、值用半角冒号 : 分隔；二维数组用 | 分隔）：</strong><br />
                    配置A:配置值<br />
                    配置B:配置值1|配置值2
                </p>
                <p>
                    <strong>JSON（请注意双引号）：</strong><br />
                    <pre>
{
    "service": "13600000000",
    "pay": "0731-84224353"
}
                    </pre>
                </p>
            </blockquote>
        @endcomponent
        @component('admin.components.form-item')
            <button class="btn btn-primary">保存</button>
            <a href="javascript: history.back()" class="btn btn-default">取消</a>
        @endcomponent
    @endcomponent
@endsection

@section('js')
    @include('admin.public.codemirror')
    <script>
        $(function(){
            codeMirrorEditor('.code-mirror');
        })
    </script>
@endsection


