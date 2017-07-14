<tr>
    <td data-name="sort_id" data-pk="{{ $item->id }}" data-reload v-ajax-edit>{{ $item->sort_id }}</td>
    <td>{{ $item->id }}</td>
    <td>{{ ($item->_level > 1 ? '|' : '') . str_repeat('—', $item->_level - 1) }} <span data-name="title" data-pk="{{ $item->id }}" v-ajax-edit>{{ $item->title }}</span></td>
    <td data-name="flag" data-pk="{{ $item->id }}" v-ajax-edit>{{ $item->flag }}</td>
    <td data-value="{{ $item->type }}" data-name="type" data-pk="{{ $item->id }}" data-options="{{ http_build_query($model->getTypeLists()) }}" v-ajax-edit>{{ $item->type_text }}</td>
    <td data-name="description" data-type="textarea" data-pk="{{ $item->id }}" v-ajax-edit>{{ $item->description }}</td>
    <td class="text-center" data-value="{{ $item->is_display }}" data-name="is_display" data-pk="{{ $item->id }}" data-options="{{ http_build_query($model::DISPLAY) }}" v-ajax-edit>{{ $model::DISPLAY[$item->is_display] }}</td>
    <td class="text-center" data-value="{{ $item->is_check }}" data-name="is_check" data-pk="{{ $item->id }}" data-options="{{ http_build_query($model::CHECK) }}" v-ajax-edit>{{ $model::CHECK[$item->is_check] }}</td>
    <td v-dropdown>
        <a href="{{ route('category.create') . '?parent_id=' . $item->id }}">添加子分类</a>
        <a href="{{ route('category.edit', $item->id) }}">编辑</a>
        <a href="{{ route('category.destroy', $item->id) }}" v-delete>删除</a>
    </td>
</tr>
@if($item->_children)
    @each('admin.category._children', $item->_children, 'item')
@endif

