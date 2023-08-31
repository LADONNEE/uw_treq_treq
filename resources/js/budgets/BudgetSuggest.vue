<template>
    <div>
        <input type="text" class="form-control"
               ref="theInput"
               v-model="inputValue"
               :placeholder="placeholderName"
               :width="widthField"
               @keyup="handleKeypress($event)"
               @keydown.tab="handleKeypressTab($event)"
               @focus="gotFocus()"
               @blur="lostFocus()" />
        <div v-show="isSuggesting" class="suggest-list" @mouseenter="gotCursor()" @mouseleave="lostCursor()">
            <div v-for="(option, index) in suggestions" class="suggest-item"
                 :class="classCurrent(index)"
                 :key="index"
                 @click="select(index)"
                >{{ option.budgetno }} {{ option.name }}</div>
        </div>
    </div>
</template>

<script>
    import { suggestions } from '../suggestions/suggestion-factory';
    import suggestMixin from '../components/suggest-mixin';
    export default {
        mixins: [ suggestMixin ],
        props: ['focused','placeholderName','widthField'],

        data() {
            return {
                source: suggestions('budgets'),
                

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