@include('admin.layouts.header')
<body>
<div id="app">
    <div class="container-fluid" id="container" v-cloak>
        <v-layout>
            <v-sider id="sidebar" breakpoint="lg" collapsible v-model="menu.collapsed">
                <a class="logo" href="./"></a>
                <v-menu :mode="menu.collapsed ? 'vertical' : 'inline'" :data="menu.data">
                    <template scope="{data}">
                        <i v-if="data.icon" :class="'anticon anticon-' + data.icon" :title="data.name"></i>
                        <a :href="data.href" v-if="data.href" class="nav-text">@{{data.name}}</a>
                        <span class="nav-text" v-else>@{{data.name}}</span>
                    </template>
                    <template scope="{data}" slot="sub">
                        <i v-if="data.icon" :class="'anticon anticon-' + data.icon" :title="data.name"></i>
                        <span class="nav-text">@{{data.name}}</span>
                    </template>
                </v-menu>
            </v-sider>
            <v-layout id="main">
                <v-header>
                </v-header>
                <v-content>
                    <div class="content">
                        @section('content')
                            <iframe id="frame" frameborder="0" scrolling="no" ref="iframe"></iframe>
                        @show
                    </div>
                </v-content>
                @include('admin.layouts.footer')
            </v-layout>
        </v-layout>
    </div>
    <v-modal :title.sync="modal.title" :visible.sync="modal.visible" @ok="modalOk" @cancel="modalCancel" class="modal-comon" :width="700" :maskClosable>
        <iframe width="100%" height="100%" frameborder="0" :src="modal.url"></iframe>
        <div slot="footer"></div>
    </v-modal>
</div>
@include('admin.layouts.scripts')
<script src="//cdn.bootcss.com/nprogress/0.2.0/nprogress.min.js"></script>
<script src="//cdn.bootcss.com/iframe-resizer/3.5.14/iframeResizer.min.js"></script>
<script src="{{ mix('/js/frame.js') }}"></script>
@yield('js')
</body>
</html>
