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
        <div  v-if="isInvalid" class="row">
            <div class="col text-danger mb-3 px-3">
                {{ validMessage }}
            </div>
        </div>
        <div v-show="isSuggesting" class="suggest-list" @mouseenter="gotCursor()" @mouseleave="lostCursor()">
            <div v-for="(option, index) in suggestions" class="suggest-item" style="white-space: pre-line"
                 :class="classCurrent(index)"
                 :key="index"
                 @click="select(index)"
                 v-html="formatWorktags(option.name)"
                ></div>
        </div>
    </div>
</template>

<script>
    import { suggestions } from '../suggestions/suggestion-factory';
    import suggestMixin from '../components/suggest-mixin';
    export default {
        mixins: [ suggestMixin ],
        props: ['focused','placeholderName','widthField','wdPrefix'],

        data() {
            return {
                source: suggestions('worktagtree'),
                
                isInvalid: false,
                validMessage: ''

            };
        },
        methods: {
            setInputValue(option, index) {
                this.inputValue = option.workday_code;
            },
            formatWorktags(item) {

                return item.replaceAll("c!/^/!c", "</b>").replace("a!/^/!a", "<b>").replace("b!/^/!b", "<br><b>>> ");
            },
            gotFocus(){
                // if(this.inputValue == "") {
                //     this.inputValue = this.placeholderName.substring(0,2);                    
                // }
            },
            lostFocus(){
                this.isInvalid = false;
                // if(this.inputValue != "" && this.inputValue.substring(0,2) != this.placeholderName.substring(0,2)){
                //     this.isInvalid = true;
                //     this.validMessage = 'This worktag must start with ' + this.placeholderName.substring(0,2);
                //     this.inputValue = this.placeholderName.substring(0,2);
                // }
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
        width: 40rem;
        background-color:rgb(196, 157, 251);
    }
 
    .suggest-list > div:nth-child(2n) {
        background-color:rgb(238, 207, 245);
        
    }

    

     
</style>