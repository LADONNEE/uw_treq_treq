<template>
    <div role="button"
         tabindex="0"
         class="button-block"
         @keydown="handleKeypress"
         @click="handleClicked"
    ><slot></slot></div>
</template>

<script>
    export default {
        methods: {
            handleKeypress(e) {
                if (e.key === 'Enter' || e.key === ' ' || e.keyCode === 32 || e.keyCode === 13) {
                    e.preventDefault();
                    this.handleClicked(e);
                }
                if (e.key === 'Escape' || e.keyCode === 27) {
                    document.activeElement.blur();
                    e.preventDefault();
                }
            },
            handleClicked(e) {
                this.$emit('click');
            }
        }
    }
</script>
