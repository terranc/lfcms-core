@include('admin.layouts.header')
<body>
<div id="app">
    <div class="container-fluid" id="container" v-cloak>
        <v-layout id="main">
            <v-content>
                <div class="content">
                    @component('admin.layouts.breadcrumb')
                        @section('nav-map')
                        @show
                    @endcomponent
                    @include('flash::message')
                    @yield('content')
                </div>
            </v-content>
        </v-layout>
    </div>
</div>
@include('admin.layouts.scripts')
<script src="//cdn.bootcss.com/iframe-resizer/3.5.14/iframeResizer.contentWindow.min.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<script></script>
@yield('js')
</body>
</html>
