@include('admin.layouts.header')
<body>
<div id="app">
    <div id="container" v-cloak>
        <aside id="sidebar">
            <div class="fixed">
                <a href="" class="logo"></a>
                <nav>
                    <template v-for="root in menu.data">
                        <dl class="menu-item menu-root" :class="{ 'menu-open': root.collapsed }" v-if="root.children && root.children.length > 0">
                            <dt>
                                <i class="icon" :class="root.icon" v-if="root.icon"></i>
                                @{{ root.name }}
                            </dt>
                            <dd>
                                <template v-for="child in root.children">
                                    <dl class="menu-item menu-sub" :class="{ 'menu-open': child.collapsed }" v-if="child.children && child.children.length > 0">
                                        <dt>
                                            <i class="icon" :class="child.icon" v-if="child.icon"></i>
                                            @{{ child.name }}
                                        </dt>
                                        <dd>
                                            <a :href="item.href" :class="item.selected ? 'selected' : ''" v-for="item in child.children">
                                                <i class="icon" :class="item.icon" v-if="item.icon"></i>
                                                @{{ item.name }}
                                            </a>
                                        </dd>
                                    </dl>
                                    <a :href="child.href" :class="child.selected ? 'selected' : ''" v-else>
                                        <i class="icon" :class="child.icon" v-if="child.icon"></i>
                                        @{{ child.name }}
                                    </a>
                                </template>
                            </dd>
                        </dl>
                        <a :href="root.href" class="menu-item menu-root" :class="root.selected ? 'selected' : ''" v-else>
                            <i class="icon" :class="root.icon" v-if="root.icon"></i>
                            @{{ root.name }}
                        </a>
                    </template>
                </nav>
            </div>
        </aside>
        <div id="main">
            <header>
                <div class="console">
                    <a href=""><span class="icon ion-ios-bell-outline"><span class="badge">42</span></span></a>
                    <a href=""><span class="icon ion-ios-person-outline"></span> 特伦C</a>
                    <a href="" v-confirm="{ title: '确认要退出吗？' }" title="退出"><span class="icon ion-log-out"></span></a>
                </div>
            </header>
            <div class="content">
                @component('admin.components.breadcrumb')
                @section('nav-map')
                @show
                @endcomponent
                @include('flash::message')
                @yield('content')
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="modal-common">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <iframe width="100%" frameborder="0" :src="modal.url"></iframe>
            </div>
        </div>
    </div>
    {{--<v-modal :title.sync="modal.title" :visible.sync="modal.visible" @ok="modalOk" @cancel="modalCancel" class="modal-comon" :width="760" :mask-closable="false">--}}
        {{--<iframe width="100%" frameborder="0" :src="modal.url"></iframe>--}}
        {{--<div slot="footer"></div>--}}
    {{--</v-modal>--}}
</div>
<script src="//cdn.bootcss.com/axios/0.16.1/axios.min.js"></script>
<script src="//cdn.bootcss.com/vue/2.3.3/vue.js"></script>
<script src="//cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<script>
    window.app.menu.data = [{
        name: '用户',
        icon: 'ion-person',
        collapsed: true,
        children: [{
            name: '用户列表',
            href: '{{ url("admin/uikit") }}'
        }],
    }, {
        name: '内容',
        icon: 'ion-ios-paper',
        collapsed: true,
        children: [{
            name: '文章管理',
            href: '{{ url('admin/document_post') }}',
        }, {
            name: '单页管理',
            href: '{{ url('admin/document') }}',
        }],
    }, {
        name: '系统',
        icon: 'ion-gear-b',
        collapsed: true,
        children: [{
            name: '系统配置',
            href: '{{ url('admin/config') }}',
        }, {
            name: '模型管理',
            href: '{{ url('admin/document_model') }}',
        }, {
            name: '分类管理',
            href: '{{ url('admin/category') }}',
        }],
    }, {
        name: '回收站',
        icon: 'ion-ios-trash-outline',
        href: '{{ url('admin/recycle_bin') }}',
    }];
</script>
@yield('js')
</body>
</html>
