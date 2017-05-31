<v-breadcrumb separator="›">
    <v-breadcrumb-item href="{{ url('admin/home') }}">首页</v-breadcrumb-item>
    @php
        $items = parse_ini_string($slot);
    @endphp
    <template v-for="(href, name) in {{ json_encode($items, 256) }}">
        <v-breadcrumb-item :href="href" v-if="href">@{{ name }}</v-breadcrumb-item>
        <v-breadcrumb-item v-else>@{{ name }}</v-breadcrumb-item>
    </template>
    <v-breadcrumb-item>@yield('title')</v-breadcrumb-item>
</v-breadcrumb>
