<template>
    <div :class="{ 'input-date-range': isRange, 'input-group': isRange }" :style="{ 'position': 'relative'}">
        <input :name="firstName" class="form-control" :data-format="format" v-model="firstValue" :required="required" v-datepicker="firstOption" />
        <template v-if="isRange">
            <span class="input-group-addon">至</span>
            <input :name="secondName" class="form-control" :data-format="format" v-model="secondValue" :required="required" v-datepicker="secondOption" />
        </template>
    </div>
</template>

<!--
name: 时间选择器
attributes:
    first-name: 开始时间控件 name（必填）
    second-name: 结束时间控件 name
    first-value: 开始时间默认值
    second-value: 结束时间默认值
    format: 格式，默认：YYYY-MM-DD
    required: 是否必填
    first-option: 开始时间配置
    second-option: 开始时间配置
-->
<script>
    export default {
        props: {
            format: {
                type: String,
                default: 'YYYY-MM-DD',
            },
            required: Boolean,
            firstName: {
                type: String,
                required: true,
            },
            secondName: String,
            firstValue: String,
            secondValue: String,
            firstOption: Object,
            secondOption: Object,
        },
        computed: {
            isRange() {
                return this.secondName;
            },
        },
    };
</script>
