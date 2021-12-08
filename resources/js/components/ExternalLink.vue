<template>
    <div v-if="link" class="external-link">
        <div :title="link"
             ref="trigger"
             @keydown="handleKeypress"
             @click="handleClicked"
             role="button"
             tabindex="0"
             class="button-block"
        >
            <i class="fas fa-external-link"></i> Link...
        </div>
        <div class="external-link__popup" role="tooltip" ref="popup" v-if="showing">
            <div class="external-link__label">Follow user provided external link:</div>
            <div class="external-link__link">
                <a :href="link" target="_treq_external" ref="link" @blur="showing = false" @keydown="linkKeydown">{{ link }}</a>
            </div>
            <button class="external-link__close" @click="showing = false">&times;</button>
        </div>
    </div>
</template>

<script>
    import { createPopper } from '@popperjs/core';
    export default {
        props: [ 'link' ],
        data() {
            return {
                showing: false,
                popper: null,
                options: {
                    placement: 'bottom',
                    modifiers: [
                        {
                            name: 'offset',
                            options: {
                                offset: [0, 8],
                            },
                        },
                    ],
                    onFirstUpdate: state => this.wasOpened(state)
                }
            }
        },
        methods: {
            toggle() {
                this.showing = !this.showing;
                if (this.showing) {
                    this.show();
                } else {
                    this.hide();
                }
            },
            wasOpened(state) {
                this.$refs.link.focus();
            },
            show() {
                this.$nextTick(() => {
                    this.$refs.popup.setAttribute('data-show', '');
                    this.popper = createPopper(this.$refs.trigger, this.$refs.popup, this.options);
                });
            },
            hide() {
                this.$nextTick(() => {
                    if (this.popper) {
                        this.popper.destroy();
                        this.popper = null;
                    }
                });
            },
            linkKeydown(e) {
                if (e.key === 'Escape' || e.keyCode === 27) {
                    this.showing = false;
                    this.hide();
                    e.preventDefault();
                }
            },
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
                this.toggle();
            }
        }
    }
</script>
