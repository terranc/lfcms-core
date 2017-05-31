/* global Vue, NProgress, iFrameResize, axios */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import bootstrap from './bootstrap';
// import iFrameResize from 'iframe-resizer';

window.parentApp = window.top.app;
let queryString = window.queryString = require('query-string');

let serializer = require('dom-form-serializer').serialize;
// var window.Vue = require('vue');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.prototype.$serialize = serializer;
// v-confirm 触发二次确认
Vue.directive('confirm', {
    bind: (el, binding) => {
        let confirm = e => {
            e.preventDefault();
            window.parentApp.$modal.confirm({
                iconType: 'question-circle-o',
                title: '确认提醒',
                content: (binding.value && binding.value.title) || '确认要删除吗？',
                // hasMask: false,
                maskClosable: true,
                okText: '确认',
                onOk: function () {
                    if (el.tagName === 'FORM') {
                        return axios.request({
                            method: (binding.value && binding.value.method) || el.method.toLowerCase() || 'get',
                            url: el.href || el.action,
                            data: Object.assign({}, (binding.value && binding.value.data) || {}, serializer(el)),
                        }).then(res => {
                            if (res.data.code > 1) {
                                window.parentApp.$modal.error({
                                    title: '提示',
                                    content: res.data.message,
                                });
                            } else {
                                window.parentApp.$message.success(res.data.message);
                                // 若data-callback指定了回调函数
                                if (el.dataset.callback && el.dataset.callback in window) {
                                    window[el.dataset.callback].call(el);
                                } else {
                                    $(el).closest(binding.arg || el).fadeOut(function () {
                                        this.remove();
                                    });
                                }
                            }
                        });
                    } else {
                        location.href = el.href;
                    }
                },
            });
        };
        if (el.tagName === 'FORM') {
            el.addEventListener('submit', confirm);
        } else {
            el.addEventListener('click', confirm);
        }
    },
});

// v-delete 触发删除确认
Vue.directive('delete', {
    bind: (el, binding) => {
        let confirm = e => {
            e.preventDefault();
            window.parentApp.$modal.confirm({
                iconType: 'question-circle-o',
                title: '确认提醒',
                content: (binding.value && binding.value.title) || '确认要删除吗？',
                // hasMask: false,
                maskClosable: true,
                okText: '确认',
                onOk: function () {
                    return axios.delete(el.href || el.action, {
                        data: Object.assign({}, (binding.value && binding.value.data) || {}, el.tagName === 'FORM' ? serializer(el) : {}),
                    }).then(res => {
                        if (res.data.code > 1) {
                            window.parentApp.$modal.error({
                                title: '提示',
                                content: res.data.message,
                            });
                        } else {
                            window.parentApp.$message.success(res.data.message);
                            // 若data-callback指定了回调函数
                            if (el.dataset.callback && el.dataset.callback in window) {
                                window[el.dataset.callback].call(el);
                            } else {
                                $(el).closest(binding.arg || el).fadeOut(function () {
                                    this.remove();
                                });
                            }
                        }
                    });
                },
            });
        };
        if (el.tagName === 'FORM') {
            el.addEventListener('submit', confirm);
        } else {
            el.addEventListener('click', confirm);
        }
    },
});
// check-all 全选
Vue.directive('check-all', {
    bind: (el, binding) => {
        var data = Object.assign({}, binding.value || {});
        let field = data.field || 'id[]';
        el.addEventListener('change', () => {
            if (el.checked) {
                el.closest(data.target || 'form').querySelectorAll(`[name='${field}'][type=checkbox]`).forEach(item => {
                    item.checked = true;
                });
            } else {
                el.closest(data.target || 'form').querySelectorAll(`[name='${field}'][type=checkbox]`).forEach(item => {
                    item.checked = false;
                });
            }
        });
    },
});
// modal iframe
Vue.directive('modal-open', {
    bind: (el, binding) => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            window.parentApp.modal = {
                title: '阿斯顿',
                visible: true,
                url: e.target.href,
            };
        });
    },
});

window.app = new Vue({
    el: '#app',
    data: {
        list: {
            columns: [],
            data: [],
            pageSize: 10,
            total: 0,
        },
    },
    methods: {
        listData(params) {
            return new Promise(resolve => {
                console.log(this.list.total);
                resolve({
                    total: this.list.total,
                    results: this.list.data,
                });
            });
        },
        pageChange(page) {
            let query = queryString.parse(location.search);
            query.page = page;
            location.href = location.pathname + '?' + queryString.stringify(query);
        },
        pageShowTotal(total, pages) {
            return `1-${pages} 全部 ${total} 条`;
        }
    },
    beforeCreate() {
        let arr = location.href.split('/');
        arr.splice(4, 0, '#');
        arr.splice(0, 4);
        window.top.history.replaceState('', '', arr.join('/')); // 不用 location 是为了浏览器返回正常处理
    },
});
// document.querySelector('#sidebar .ant-menu-root').querySelector('a')
