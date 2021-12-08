<template>
    <div>
        <input ref="typeahead" type="text" v-model="input" @keydown="handleKeypress($event)" @blur="blurSlow()" class="form-control">
        <div ref="suggestions" class="tt-menu" v-show="showSuggestions">
            <div class="tt-suggestion" v-for="(option, index) in source.suggestions"
                 :class="isHighlighted(index)"
                 :key="getOptionKey(option)"
                 @click="selected(option)"
                 @mouseenter="setCursor(index)"
            >{{ displayOption(option) }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [ 'value', 'source' ],
        data() {
            return {
                input: '',
                suggesting: false,
                cursor: 0
            };
        },
        created() {
            this.input = this.value;
        },
        watch: {
            value(val) {
                this.input = val;
            }
        },
        computed: {
            suggestions() {
                return this.source.suggestions;
            },
            showSuggestions() {
                return this.suggesting && this.source.suggestions.length > 0;
            }
        },
        methods: {
            setInputValue(option) {
                this.input = option.name;
            },
            displayOption(option) {
                return option.name;
            },
            getOptionKey(option) {
                return option.id;
            },
            isHighlighted(index) {
                return {
                    "tt-cursor": (index === this.cursor)
                };
            },
            setCursor(index) {
                this.cursor = index;
            },
            cursorDown() {
                let moved = this.cursor + 1;
                if (moved < this.source.suggestions.length) {
                    this.cursor = moved;
                }
            },
            cursorUp() {
                let moved = this.cursor - 1;
                if (moved >= 0) {
                    this.cursor = moved;
                }
            },
            handleKeypress(e) {
                let keyCode = e.keyCode;
                if (keyCode === 13 || keyCode === 9) {
                    this.selected(this.source.suggestions[this.cursor]);
                    this.reset();
                } else if (keyCode === 38) {
                    this.cursorUp();
                } else if (keyCode === 40) {
                    this.cursorDown();
                } else if (keyCode === 27) {
                    this.reset();
                } else {
                    this.search();
                    return;
                }
                e.preventDefault();
            },
            focus() {
                this.$refs.typeahead.focus();
            },
            select() {
                this.$refs.typeahead.select();
            },
            reset() {
                this.$refs.typeahead.blur();
                this.suggesting = false;
                this.cursor = 0;
            },
            search() {
                this.suggesting = true;
                this.source.search(this.input);
            },
            selected(option) {
                this.setInputValue(option);
                this.$refs.typeahead.blur();
                this.suggesting = false;
                this.$emit('selected', option)
            },
            blurSlow() {
                setTimeout(function(){
                    this.reset();
                }.bind(this), 200);
            }
        }
    }
</script>

<style scoped>
    .tt-menu {
        position: absolute;
        z-index: 1100;
    }
</style>