/* global Vue, NProgress, iFrameResize */
import bootstrap from './bootstrap';

window.app = new Vue({
    el: '#app',
    data: {
        menu: {
            collapsed: false,
            data: [],
        },
        modal: {
            title: '加载中...',
            visible: false,
            url: '',
        },
    },
    methods: {
        modalOk() {
            this.modal.visible = false;
        },
        modalCancel() {
            this.modal.visible = false;
        },
    },
    computed: {
        modalHeight() {
            return document.body.clientHeight * 0.65;
        },
    },
    mounted() {
        let iframe = document.querySelector('#frame');
        iFrameResize({
            log: false,
            autoResize: true,
            checkOrigin: false,
            heightCalculationMethod: 'max',
            initCallback: function (messageData) {
            },
            resizedCallback: function (messageData) {
            },
            messageCallback: function (messageData) {
            },
            closedCallback: function (messageData) {
            }
        });
        NProgress.configure({
            minimum: 0.2,
            trickleSpeed: 300,
        });
        document.body.addEventListener('click', function (e) {
            if (e.target.tagName === 'A' && e.target.closest('#sidebar .ant-menu-root')) {
                NProgress.start();
                if (e.target.href.indexOf('#') === -1) {
                    location.href = e.target.href;
                } else {
                    iframe.setAttribute('src', bootstrap.getRoot() + e.target.href.substring(e.target.href.indexOf('#') + 2));
                    document.title = e.target.innerText;
                }
                NProgress.inc();
            }
        });
        iframe.addEventListener('load', function () {
            NProgress.done();
            window.document.title = this.contentDocument.title;
        });
        // 加载默认页
        if (location.hash.indexOf('#/') !== -1) {
            iframe.setAttribute('src', bootstrap.getRoot() + location.hash.substr(2));
        } else {
            iframe.setAttribute('src', bootstrap.getRoot() + 'home');
        }
    },
});
