# LFCMS-template

## 开发规范

## 快速入门

## 配置

### 缓存

#### 让 File Driver 支持 Tags
为了方便的使用laravel cache 的 tags 功能，按如下配置，其它使用方法与 `file` 缓存无异
```php
'default' => env('CACHE_DRIVER', 'tfile'),
```

.env: 
```env
CACHE_DRIVER=tfile
```

## 工具

### Traits

### Helpers

## 组件

### Laravel 组件

#### 面包屑
**breadcrumb** 组件已在 `app.blade.php` 装载，且每个继承 `app.blade.php` 的页面会自动将当前页面 `<title />` 的内容作为最后一个节点。你只需在页面中插入如下代码，配置中间节点即可（采用`.ini`格式，将用`parse_ini_string`解析）：

```html
<head>
    <title>创建用户</title>
</head>
...
```
```blade
...
@section('nav-map')
    ; 没有连接也务必添加"="号
    用户=
    用户管理=admin/users
@endsection
...
```
效果：
> [首页](./) > 用户 > [用户管理](../admin/users) > 创建用户


#### 表单

`form-table`旨在让你快速的搭建数据创建、修改的表单，做好了 ajax、错误提示、crsf等封装，你需要做的仅仅需要关注几个参数：

- `data`: 操作数据对象，如：`$user` 
- `model`: 指定表单操作 `model` 名称
- `class`: 自定义表单 `class`


Blade:
```blade
@component('admin.components.form-table', ['data'=>$user, 'model'=>'users', 'class'=>'custom-form-class'])
    ...
@endcompent
```

转化为 Html 后：
```html
<!-- 若 $data 为 null 将自动把属性 action 置为 /xxx/123/create -->
<form enctype="multipart/form-data"
  method="POST"
  action="/xxx/123/edit"
  novalidate
  accept-charset="UTF-8"
  autocomplete="off"
  onsubmit="return false;"
  v-ajax-form>
    <!-- 如果 $data 有值 -->
    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="id" value="123">
    <!-- 如果 $data 为空 -->
    <input type="hidden" name="_method" value="POST">
    ...
    <input type="hidden" name="_token" value="...">
    <input type="hidden" name="from_url" value="上一页 Url，方便跳转">
</form>
```
<p class="tip">
<code>from_url</code> 等于 <code>$_SERVER['HTTP_REFERER']</code>
</p>

##### 表单项
为了方便、快速、统一的创建表单项，同时又不失原生 form 表单的灵活性、兼容性。
- `label`: Label 文案
- `class`: 附加 label class，默认：``，可选值: `top`*（建议：为提升 label 的浏览体验，常用于 `textarea` 等多行表单控件的时候）*

```blade
@component('admin.components.form-item', ['label'=>'名字'])
    ...
@endcomponent
```
示例：
```blade
@component('admin.components.form-table', ['data'=>$user, 'model'=>'users'])
    @component('admin.components.form-item', ['label'=>'名字'])
        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
    @endcomponent
    @component('admin.components.form-item', ['label'=>'邮箱'])
        <input type="text" class="form-control" size="40" name="email" value="{{ $user->email }}">
    @endcomponent
    @component('admin.components.form-item', ['label'=>'状态'])
        <lf-options name="status" value="{{ $user->status }}" :source="{ 0: '禁用', 1: '启用' }"></lf-options>
    @endcomponent
    @component('admin.components.form-item', ['label'=>'注册时间'])
        {{ $user->created_at ?: '-' }}
    @endcomponent
@endcomponent
```
### Vue 组件

#### 选项组
该组件旨为减少臃肿的逻辑判断，减少代码量，可以方便、快速的生成 select、checkbox、radio 三种选项组。
- `type`: 支持 select、checkbox、radio
- `name`: `required` 指定控件 name，用于表单提交（checkbox 类型将自动添加`[]`后缀，如`name="goods_type"`，将自动转化为`name="goods_type[]"`）
- `source`: `required` 选项，传入一个 json 对象或 array
- `value`: 默认选中值

```blade
<!-- source 接受一个 json 对象 -->
<lf-options name="status" value="{{ $user->status }}" :source="{ 0: '禁用', 1: '启用' }"></lf-options>
<!-- source 支持 array -->
<lf-options name="status" value="{{ $user->status }}" :source="['禁用', '启用']"></lf-options>
<!-- type 可指定 checkbox / select / radio 三种表现形式 -->
<lf-options name="status" type="checkbox" value="{{ $user->status }}" :source="['禁用', '启用']"></lf-options>
<!-- 当 type 未指定时，source 节点个数小于 2 个将默认 radio，否则默认 checkbox -->
<lf-options name="category_id" value="{{ $user->type }}" :source="{ 'spring': '春天', 'summer': '夏天', 'autumn': '秋天', 'winter': '冬天' }"></lf-options>
```

#### 日期/时间选择器（可选择区间）
支持多种形式的`DatePicker`、`DateTimePicker`，且支持区间范围选择。

<img src="http://terran.cc/lfcms-template/images/datetimepicker.png" />
<img src="http://terran.cc/lfcms-template/images/datetimepicker2.png" />

<img src="http://terran.cc/lfcms-template/images/datetimepicker_range.png" />

- `format`: 时间格式，默认：`YYYY-MM-DD`，若指定时分秒（`YYYY-MM-DD HH:mm:ss`）控件将出现时间选择器
- `first-name`: `required` (开始)日期/时间的表单 name
- `second-name`: 若需要区间选择时传入结束日期/时间的表单 name
- `first-value`: （开始）日期/时间默认值
- `second-value`: 结束日期/时间默认值
- `required`: `Boolean` 是否必填，默认:`false`，为`true`时将隐藏清空按钮
- `first-option`: `Object` （开始）日期/时间组件配置项，如指定最小可选日期：`{ minDate: '{{ date('Y-m-d H:i') }}' }`
- `second-option`: `Object` 结束日期/时间组件配置项 

<p class="tip">
    组件基于 <a href="https://github.com/Eonasdan/bootstrap-datetimepicker" target="_blank">bootstrap-datetimepicker</a> 开发，其它配置见第三方文档：<br /><a href="http://eonasdan.github.io/bootstrap-datetimepicker/Options/" target="_blank">http://eonasdan.github.io/bootstrap-datetimepicker/Options/</a>
</p>

### Vue Directive
#### v-delete
触发二次确认后提交一个`DELETE`请求，支持`a`和`form'`，提交地址为`href`或`action`。

binding:
- `title`: 指定二次确认提示文案，默认为『确认要删除吗？』

demo:
```html
<a href="{{ route('users.destroy', $user->id) }}" v-delete>删除</a>
<a href="{{ url('admin/users', ['id'=>38]) }}" v-delete="{ title: '确认要彻底删除吗？' }">删除</a>
<form action="{{ url('admin/users', ['id'=>3]) }}" v-delete>
    <button class="btn btn-primary">表单提交删除</button>
</form>
```
#### v-confirm
除了删除这种特定的与 laravel 结合较深的情况，也不排除还有其它需要触发二次确认的场景。<br>
支持`a`和`form`。<br>
- `form`: 默认发起一个`ajax`请求，若设置了回调函数，将在成功之后执行。<br>
- `a`: 将跳转到`href`。

binding:
- `title`: 指定二次确认提示文案，默认为『确认要操作吗？』
- `method`: 指定 form method，默认：`get`
- `data`: form 附加请求数据，如：`{ nickname: '特伦C' }`
- `callback`: 成功回调函数，传入 window 域 function 名称（字符串）

> 回调函数有一个参数，为返回的 json 数据，并绑定作用于到触发 DOM

#### v-check-all
用于全选指定容器中某组`checkbox`。

binding:
- `target`: 指定容器范围，可传入一个 jQuery selector（基于`closest`），如：`.check-wrap`，默认为当前 form。
- `field`: 指定需要选中的`checkbox`的`name`名，默认: `id[]`

demo:
```html
<form>
    <div><input type="checkbox" v-check-all="{ field: 'user_id[]' }"></div>
    <div><input type="checkbox" name="user_id[]" value="1"></div>
    <div><input type="checkbox" name="user_id[]" value="2"></div>
    <div><input type="checkbox" name="user_id[]" value="3"></div>
</form>
```

#### v-datepicker
给 input 绑定 datepicker。当设置`required`时，将隐藏清空按钮。

dataset:
- `format`: 日期格式，默认：`YYYY-MM-DD`

binding: 
- datepicker 配置，参考：http://eonasdan.github.io/bootstrap-datetimepicker/Options/

demo:
```html
<input name="date" class="form-control" data-format="YYYY-MM-DD" required v-datepicker="{ minDate: '2017-01-01' }" />
```

#### v-select
快速绑定 jquery select2。支持 `multiple`。

dataset:
- `selected`: 选中值

binding: 
- select2 配置，参考：https://select2.github.io/options.html

demo:
```html
<select class="form-control" name="field" v-select data-selected="3">
    <option>请选择分类..</option>
    <option value="1">分类1</option>
    <option value="2">分类2</option>
    <option value="3">分类3</option>
    <option value="4">分类4</option>
</select>
```

#### v-ajax-form
ajax 表单，自动将 Laravel validation 的错误信息呈现在界面上，让前端界面无需关注数据验证。

> TODO: 暂时提示错误之后需要再次提交才会清除通过验证的红框，待完善

demo:
```html
<form action="" method="post" v-ajax-form>
    ...
</form>
```

#### v-ajax-edit
表格里快速更新数据，基于 **x-editable**

dataset:
- `type`: 编辑类型，默认: `text`，若设置了`v-options`则默认为`select`
- `name`: 控件`name`
- `pk`: 主键值
- `options`: 选项值，query 形式，可借助`http_build_query`，如：`data-options="{{ http_build_query($arr) }}"`

demo:
```html
<tr>
    <td data-type="text" data-name="name" data-pk="{{ $user->id }}" v-ajax-edit>{{ $user->name }}</td>
    <td data-value="{{ $user->status }}" data-name="status" data-pk="{{ $user->id }}" data-options="0=禁用&1=启用" v-ajax-edit>{{ $user->status_text }}</td>
</tr>
```

#### v-modal-open
绑定`a`标签，点击打开一个浮层，加载`href`地址，可用于不宜打断主流程的分支流程使用。

```html
<a href="http://baidu.com" v-modal-open>打开浮层</a>
```

#### v-tooltip
<img src="http://terran.cc/lfcms-template/images/tips.png" />

demo:
```html
<a href="http://baidu.com"  v-tooltip title="打开百度">Tooltip</a>
```
