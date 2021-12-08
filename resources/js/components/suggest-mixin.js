export default {
    props: ['value'],
    data() {
        return {
            inputValue: '',
            suggestions: [],
            isSuggesting: false,
            cursor: -1,
            hasFocus: false,
            hasCursor: false
        }
    },
    created() {
        this.inputValue = this.value;
    },
    watch: {
        value() {
            this.inputValue = this.value;
        },
        inputValue() {
            this.$emit('input', this.inputValue);
        }
    },
    methods: {
        takeSuggestions(suggestions) {
            this.suggestions = suggestions;
            this.isSuggesting = this.suggestions.length > 0;
        },
        takeAsyncSuggestions(suggestions) {
            if (suggestions.length > 0) {
                this.suggestions = suggestions;
                this.isSuggesting = true;
            }
        },
        search() {
            const sync = this.takeSuggestions.bind(this);
            const async = this.takeAsyncSuggestions.bind(this);
            this.source(this.inputValue, sync, async);
        },
        stopSuggesting() {
            this.isSuggesting = false;
            this.cursor = -1;
        },
        classCurrent(index) {
            return {
                "current": (index === this.cursor)
            };
        },
        handleKeypress(e) {
            e.preventDefault();
            let keyCode = e.keyCode;
            if (keyCode === 13) {
                if (this.cursor >= 0) {
                    e.preventDefault();
                    this.select(this.cursor);
                    this.stopSuggesting();
                    return;
                }
            } else if (keyCode === 38) {
                this.cursorUp();
                return;
            } else if (keyCode === 40) {
                this.cursorDown();
                return;
            } else if (keyCode === 27) {
                this.stopSuggesting();
                return;
            }
            this.search();
        },
        setCursor(index) {
            this.cursor = index;
        },
        cursorDown() {
            let moved = this.cursor + 1;
            if (moved < this.suggestions.length) {
                this.cursor = moved;
            }
        },
        cursorUp() {
            let moved = this.cursor - 1;
            if (moved >= 0) {
                this.cursor = moved;
            }
        },
        select(index) {
            this.setInputValue(this.suggestions[index], index);
            this.stopSuggesting();
            this.$emit('selected', this.suggestions[index]);
        },
        gotFocus() {
            this.hasFocus = true;
            this.$emit('focus');
            this.search();
        },
        lostFocus() {
            this.hasFocus = false;
            this.$emit('blur');
            this.blurSlow();
        },
        gotCursor() {
            this.hasCursor = true;
        },
        lostCursor() {
            this.hasCursor = false;
            this.blurSlow();
        },
        blurSlow() {
            setTimeout(function(){
                this.cautiouslyClose();
            }.bind(this), 100);
        },
        cautiouslyClose() {
            if (!this.hasFocus && !this.hasCursor) {
                this.stopSuggesting();
            }
        },
        setInputValue(option, index) {
            this.inputValue = this.optionValue(option, index);
        },
        optionValue(option, index) {
            return option;
        },
        optionKey(option, index) {
            return index;
        }
    }
}
