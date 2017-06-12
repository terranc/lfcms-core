<ol class="breadcrumb">
    <li><a href="{{ url('admin/home') }}">首页</a></li>
    @php
        $items = parse_ini_string($slot);
    @endphp
    <template v-for="(href, name) in {{ json_encode($items, 256) }}">
        <li v-if="href"><a :href="href.substring(0, 4) === 'http' ? href : ('/' + href)">@{{ name }}</a></li>
        <li v-else>@{{ name }}</li>
    </template>
    <li class="active">@yield('title')</li>
</ol>
