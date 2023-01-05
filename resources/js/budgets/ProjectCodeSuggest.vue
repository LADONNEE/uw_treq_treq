<template>
    <div>
        <input type="text" class="form-control" style="width:20rem;" placeholder="PCA/Workday Code or Description"
               ref="theInput"
               v-model="inputValue"
               @keyup="handleKeypress($event)"
               @focus="gotFocus()"
               @blur="lostFocus()" />
        <div v-show="isSuggesting" class="suggest-list" @mouseenter="gotCursor()" @mouseleave="lostCursor()">
            <div v-for="(option, index) in suggestions" class="suggest-item"
                 :class="classCurrent(index)"
                 :key="index"
                 @click="select(index)"
                 @mouseenter="setCursor(index)"
            >PROJECT CODE: [{{ option.code === "" ? "no code" : option.code }}] {{ option.description }} ___ WORKDAY: [{{ option.workday_code }}] {{ option.workday_description }}</div>
        </div>
    </div>
</template>

<script>
    import { suggestions } from '../suggestions/suggestion-factory';
    import suggestMixin from '../components/suggest-mixin';
    export default {
        mixins: [ suggestMixin ],
        props: ['focused'],
        data() {
            return {
                source: suggestions('project_codes')
            };
        },
        methods: {
            setInputValue(option, index) {
                this.inputValue = option.id;
            }
        },
        mounted() {
            if (this.focused) {
                this.$nextTick(() => {
                    this.$refs.theInput.focus();
                    this.$refs.theInput.select();
                });
            }
        }
    }
</script>

<style scoped>
    .suggest-list {
        width: 50rem;
    }
    .suggest-item {
        border-bottom: 2px solid;
    }
</style>