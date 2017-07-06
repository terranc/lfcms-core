/* global Vue, NProgress, iFrameResize, axios */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-notify');
require('jquery-query-object');
require('jquery-easy-loading/dist/jquery.loading');
require('select2/dist/js/select2');
require('select2/dist/js/i18n/zh-CN');
require('eonasdan-bootstrap-datetimepicker');
require('bootstrap-add-clear');
require('x-editable/dist/bootstrap3-editable/js/bootstrap-editable');
$.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit">保存</button>';
$.fn.select2.defaults.set('theme', 'bootstrap');
import datepicker from './components/datepicker.vue';
import options from './components/options.vue';
$.Loading.setDefaults({
    message: '请稍后...',
});
import bootbox from 'bootbox';
window.bootbox = bootbox;
window.bootbox.setDefaults({
    title: '提示',
    locale: 'zh_CN',
    backdrop: true,
    className: 'lf-model',
});
$.notifyDefaults({
    element: 'body',
    allow_dismiss: true,
    newest_on_top: true,
    placement: {
        from: 'top',
        align: 'center'
    },
    delay: 2000,
    animate: {
        enter: 'animated fadeInDown',
        exit: 'animated fadeOutUp'
    },
});
// import iFrameResize from 'iframe-resizer';

// window.parentApp = window.top.app;
// let queryString = window.queryString = require('query-string');

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
            bootbox.confirm({
                title: '操作确认',
                message: (binding.value && binding.value.title) || '确认要操作吗？',
                callback(result) {
                    if (!result) return;
                    if (el.tagName === 'FORM') {
                        return axios.request({
                            method: (binding.value && binding.value.method) || el.method.toLowerCase() || 'get',
                            url: el.href || el.action,
                            data: Object.assign({}, (binding.value && binding.value.data) || {}, serializer(el)),
                        }).then(res => {
                            if (res.data.code < 0) {
                                bootbox.alert({
                                    title: '错误',
                                    message: res.data.message,
                                });
                            } else {
                                $.notify(res.data.message, {
                                    type: 'success',
                                });
                            }
                            // 若 callback 指定了回调函数
                            if (binding.value && binding.value.callback in window) {
                                window[binding.value.callback].call(el, res.data);
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
            bootbox.confirm({
                title: '操作确认',
                message: (binding.value && binding.value.title) || '确认要删除吗？',
                buttons: {
                    confirm: {
                        className: 'btn-primary btn-danger'
                    },
                },
                callback: function (result) {
                    if (!result) return;
                    var form = $('<form>', {
                        'method': 'POST',
                        'action': el.href || el.action,
                    });
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': $('meta[name="csrf-token"]').attr('content') || ''
                    }));
                    form.append($('<input>', {
                        'name': '_method',
                        'type': 'hidden',
                        'value': 'delete',
                    }));
                    let data;
                    if (el.tagName === 'FORM') {
                        data = serializer(el);
                        Object.keys(data).map((item, index) => {
                            form.append($('<input>', {
                                'name': index,
                                'type': 'hidden',
                                'value': item,
                            }));
                        });
                    }
                    form.appendTo('body').submit();
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
    inserted: (el) => {
        // 扩大表格复选框点击范围
        $(el).closest('table').find('.checkbox-col').each(function() {
            $(this).on('click', e => {
                $(e.target).find(':checkbox').trigger('click');
            });
        });
    },
});
// tooltip
Vue.directive('tooltip', {
    bind: (el, binding) => {
        $(el).tooltip(Object.assign({}, {
            container: 'body',
        }, (binding && binding.value) || {}));
    },
});
// modal iframe
Vue.directive('modal-open', {
    bind: (el, binding) => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            $('#modal-common').modal();
            window.app.modal.url = e.target.href;
        });
    },
});
// datepicker
Vue.directive('datepicker', {
    inserted: (el, binding) => {
        let format = el.dataset.format || 'YYYY-MM-DD';
        $(el).datetimepicker(Object.assign({
            locale: 'zh-cn',
            format: format,
            // debug: true,
            showTodayButton: true,
            allowInputToggle: true,
            // keepInvalid: true,
            dayViewHeaderFormat: 'YYYY 年 MM 月',
            toolbarPlacement: 'bottom',
            showClear: !el.required,
            icons: {
                time: 'ion-ios-time-outline',
                date: 'ion-ios-calendar-outline',
                up: 'ion-ios-arrow-up',
                down: 'ion-ios-arrow-down',
                previous: 'ion-ios-arrow-left',
                next: 'ion-ios-arrow-right',
                today: 'ion-pinpoint',
                clear: 'ion-ios-trash-outline',
                close: 'ion-ios-close-empty',
            },
        }, binding.value || {}));
        // setTimeout(() => {
        //     console.log(el.value);
        //     $(el).data("DateTimePicker").date(el.value);
        // }, 100);
    },
});
// select2
Vue.directive('select', {
    inserted: (el, binding) => {
        let selected = el.dataset.selected || '';
        $('option:not([value])', el).attr('value', '');
        $(el).val(selected)
            .select2(Object.assign({}, {
                // placeholder: placeholder,
                // allowClear: el.required ? false : true,
                maximumInputLength: 10,
                minimumResultsForSearch: 8,
                width: el.multiple ? '100%' : $(el).outerWidth() + 20,
                language: 'zh-CN',
            }, binding.value || {}));
    },
});
// ajax form
Vue.directive('ajax-form', {
    bind: (el, binding) => {
        $(el).on('submit', e => {
            e.preventDefault();
            // let data = serializer(e.target);
            let data = new FormData(e.target);
            axios.post(e.target.action, data).then(res => {
                $('.form-group', el).removeClass('has-error');
                if (res.data.code > 0) {
                    bootbox.alert({
                        message: res.data.message,
                        callback: () => {
                            if (res.data.redirect_url) {
                                location.href = res.data.redirect_url;
                            } else {
                                location.reload();
                            }
                        },
                    });
                } else if (res.data.code === -422) {
                    if (res.data.data !== null && res.data.toString() === '[object Object]') {
                        let firstError;
                        firstError = Object.keys(res.data.data)[0];
                        Object.keys(res.data.data).forEach(item => {
                            let field = $(`[name=${item}]`, el);
                            let group = field.closest('.form-group').addClass('has-error').find('ul').empty();
                            res.data.data[item].forEach(error => {
                                group.append(`<li>${error}</li>`);
                            });
                        });
                        $(`[name=${firstError}]`, el).trigger('focus');
                    } else {
                        bootbox.alert(res.data.message);
                    }
                } else {
                    bootbox.alert(res.data.message);
                }
            });
        });
    },
});
// ajax-edit 在表格里快速更新数据
Vue.directive('ajax-edit', {
    inserted: (el, binding) => {
        let elLink = document.createElement('a');
        Object.keys(el.dataset).forEach((item, index) => {
            elLink.dataset[item] = el.dataset[item];
            el.removeAttribute('data-' + item);
        });
        $(el).wrapInner(elLink).children('a').editable({
            ajaxOptions: {
                type: 'PATCH',
            },
            type: elLink.dataset.options ? 'select' : 'text',
            source() {
                return $.query.parseNew(this.dataset.options).keys;
            },
            title() {
                return $(this).closest('td').data('title');
            },
            url(params) {
                let data = {};
                data[params.name] = params.value;
                data['id'] = params.pk;
                let url = location.origin + location.pathname + '/' + data['id'];
                return axios.patch(url, data);
            },
            success(res, newValue) {
                if (res.data.code > 0) {
                    $.notify(res.data.message, {
                        type: 'success',
                    });
                } else {
                    bootbox.alert(res.data.data[elLink.dataset.name][0]);
                    return false;
                }
            },
        });
    },
});

Vue.component('lf-datepicker', datepicker);
Vue.component('lf-options', options);

import regenUrl from './filters/regen-url';
Vue.filter('regenUrl', regenUrl);
window.app = new Vue({
    el: '#app',
    data: {
        menu: {
            collapsed: false,
            data: [],
        },
        window: window,
        modal: {
            title: '加载中...',
            visible: false,
            url: 'about:blank',
        },
        body: $('body'),
        page: {},
    },
    methods: {
        loading(opt) {
            this.body.loading(opt);
        },
        hideLoading() {
            this.body.loading('stop');
        },
    },
    mounted() {
        $('.table').find('thead th').each(function() {
            if (!$(this).closest('table')[0].column) {
                $(this).closest('table')[0].column = [];
            }
            $(this).closest('table')[0].column.push($(this).text().trim());
        }).end().find('tbody th, tbody td').each(function() {
            this.dataset.title = $(this).closest('table')[0].column[$(this).index()];
        });
        $('thead th[data-sort-field]').each(function() {
            let that = this;
            this.setAttribute('role', 'sortcolumn');
            if (that.dataset.sortField === $.query.get('sort_field')) {
                this.dataset.sortBy = $.query.get('sort_by');
            }
            this.addEventListener('click', (e) => {
                that.dataset.sortBy = that.dataset.sortBy === 'desc' ? 'asc' : 'desc';
                $(this).closest('table').loading({
                    message: '数据加载中...',
                });
                $.query.REMOVE('page');
                $.query.SET('sort_field', that.dataset.sortField);
                $.query.SET('sort_by', that.dataset.sortBy);
                location.href = location.pathname + $.query.toString();
            });
        });
        // 如果 url hash 中有值，将该值存储于 sessionStorage 中，用于新窗口打开菜单链接后初始化选中
        $('.table-footer').on('change', '[name=action]', function(e) {
            let form = $(this).closest('form');
            let ids = [];
            $('input:checkbox[name="id[]"]:checked', form).each(function() {
                ids.push(this.value);
            });
            if (ids.length === 0) {
                bootbox.alert({
                    title: '提示',
                    message: '请选择操作对象！',
                    callback: () => {
                        $(this).val('');
                    },
                });
                return false;
            }
            switch ($(this).val()) {
                case '':
                    return false;
                case 'delete':
                    bootbox.confirm({
                        title: '操作确认',
                        message: '确认要删除吗？',
                        buttons: {
                            confirm: {
                                className: 'btn-primary btn-danger'
                            },
                        },
                        callback: function (result) {
                            if (result) {
                                let url = location.pathname + '/' + ids.join(',') + $.query.toString();
                                var ajaxForm = $('<form>', {
                                    'method': 'POST',
                                    'action': url,
                                });
                                ajaxForm.append($('<input>', {
                                    'type': 'hidden',
                                    'name': '_token',
                                    'value': $('meta[name="csrf-token"]').attr('content') || ''
                                }));
                                ajaxForm.append($('<input>', {
                                    'name': '_method',
                                    'type': 'hidden',
                                    'value': 'delete',
                                }));
                                ajaxForm.appendTo('body').submit();
                            } else {
                                $(e.target).val('');
                            }
                        },
                    });
                    break;
                default:
                    form.attr('action', location.pathname + '/' + ids.join(',') + '/' + $(this).val());
                    form.submit();
                    break;
            }
        });
    },
});
$(function() {
    // 选中当前菜单项
    if (location.hash) {
        sessionStorage.setItem('menu-current', location.hash.substring(1));
    }
    $('#sidebar').on('click', 'dl.menu-item > dt', function(e) {
        let dl = $(this).parent();
        dl.toggleClass('menu-open');
        e.preventDefault();
    }).on('click', 'nav a[href]', function(e) {
        sessionStorage.setItem('menu-current', this.href);
        // 侧边栏链接点击后会在 url hash 中附上链接地址
        this.href = this.href.replace(this.hash, '') + '#' + this.href.replace(this.hash, '');
    }).find(`a[href="${sessionStorage.getItem('menu-current')}"]`).addClass('selected');

    $('.selected').parents('.menu-item').addClass('menu-open');
    // 需要一键清空的 input 添加 data-clear
    $('input[data-clear]').addClear({
        closeSymbol: '✖',
        symbolClass: '',
    });
});
// document.querySelector('#sidebar .ant-menu-root').querySelector('a')
