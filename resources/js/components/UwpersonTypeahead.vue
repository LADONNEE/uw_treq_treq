<template>
    <div :id="'container_' + id">
        <input type="text" v-model="value" :name="inputName" :id="id" class="form-control" />
    </div>
</template>

<script>
    import UwpersonTypeahead from './uwperson-typeahead';
    export default {
        props: {
            person: {
                type: String,
                required: false,
                default: ''
            },
            inputName: {
                type: String,
                required: false,
                default: 'uwperson_typeahead'
            }
        },
        data() {
            return {
                id: this.generatedId(),
                value: this.person,
                uwpersonTypeahead: null
            };
        },
        watch: {
            person(val) {
                this.value = val;
            }
        },
        methods: {
            generatedId() {
                return 'uwpta_' + Math.random().toString(36).substr(2, 9);
            },
            accept(option) {
                this.$emit('selected', option);
            }
        },
        mounted() {
            this.$nextTick(() => {
                let that = this;
                this.uwpersonTypeahead = UwpersonTypeahead.init('#' + this.id, that.accept);
            });
        },
        beforeDestroy: function () {
            if (this.uwpersonTypeahead) {
                this.uwpersonTypeahead.typeahead('destroy');
                // Typeahead doesn't clean up all of its html
                $('#container_' + this.id).empty();
            }
        }
    }
</script>
