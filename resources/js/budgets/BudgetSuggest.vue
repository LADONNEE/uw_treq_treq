<template>
    <div>
        <input type="text" class="form-control" style="width:8rem;" placeholder="00-0000"
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
            >{{ option.budgetno }} {{ option.name }}</div>
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
                source: suggestions('budgets')
            };
        },
        methods: {
            setInputValue(option, index) {
                this.inputValue = option.budgetno;
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
        width: 20rem;
    }
</style>