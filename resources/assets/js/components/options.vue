<template>
    <div>
        <template v-if="getType === 'checkbox'">
            <div class="checkbox-inline" v-for="(option, index) in options">
                <label>
                    <input type="checkbox" :name="name + '[]'" :value="index" :checked="value === index.toString()" @change="onChange">
                    {{ option }}
                </label>
            </div>
        </template>
        <template v-else-if="getType === 'radio'">
            <div class="radio-inline" v-for="(option, index) in options">
                <label>
                    <input type="radio" :name="name" :value="index" :checked="value === index.toString()" @change="onChange">
                    {{ option }}
                </label>
            </div>
        </template>
        <template v-else>
            <select :name="name" class="form-control" @change="onChange">
                <option :value="index" :selected="value === index.toString()" v-for="(option, index) in options">{{ option }}</option>
            </select>
        </template>
    </div>
</template>

<script>
export default {
    name: 'options',
    props: {
        type: String,
        name: {
            type: String,
            required: true,
        },
        value: String,
        source: {
            type: [Array, Object],
            default: {},
            required: true,
        },
    },
    computed: {
        getType() {
            if (this.type) {
                return this.type;
            } else {
                if (Object.keys(this.options).length > 2) {
                    return 'select';
                } else {
                    return 'radio';
                }
            }
        },
        options() {
            if (this.source instanceof Array) {
                return this.source.reduce((result, item, index) => {
                    result[index] = item;
                    return result;
                }, {});
            }
            return this.source;
        },
    },
    methods: {
        onChange(e) {
            this.$emit('change', e);
        },
    },
};
</script>
