<template>
    <div class="on-call__container">
        <button class="on-call"
                :class="isOnCallClass"
                ref="button"
                @click.prevent="show"
        >{{ buttonText }}</button>
        <div class="on-call__dialog" ref="modal" role="tooltip" v-show="isActive">
            <div class="mb-2">Show this order in the On Call list</div>
            <div>
                <div class="form-check on-call__check">
                    <input class="form-check-input" name="on_call" type="radio" :id="offId" v-model="onCallForm" value="0">
                    <label class="form-check-label" :for="offId">
                        Not On Call
                    </label>
                </div>
                <div class="form-check on-call__check">
                    <input class="form-check-input" name="on_call" type="radio" :id="onId" v-model="onCallForm" value="1">
                    <label class="form-check-label" :for="onId">
                        On Call
                    </label>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-secondary btn-sm" @click.prevent="save">Save</button>
                <button class="btn btn-light btn-sm" @click.prevent="hide">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { createPopper } from '@popperjs/core';
    import randomString from "../utilities/random-string";
    import OnCallStore from "./on-call-store";
    export default {
        props: [ 'url' ],
        data() {
            const idSuffix = randomString();
            return {
                store: new OnCallStore(this.url),
                onCallForm: 0,
                onId: 'on-call-on-' + idSuffix,
                offId: 'on-call-off-' + idSuffix,
                isActive: false,
                popper: null,
            }
        },
        computed: {
            storeOnCall() {
                return this.store.onCall;
            },
            buttonText() {
                return (this.store.onCall) ? 'On Call' : 'Not On Call';
            },
            isOnCallClass() {
                if (this.store.onCall) {
                    return {
                        "on-call--on": true,
                        "on-call--off": false,
                    };
                }
                return {
                    "on-call--on": false,
                    "on-call--off": true,
                };
            }
        },
        watch: {
            storeOnCall(val) {
                this.onCallForm = val;
            }
        },
        methods: {
            show() {
                if (!this.isActive) {
                    this.showPopper();
                }
            },
            hide() {
                if (this.isActive) {
                    this.isActive = false;
                }
            },
            save() {
                this.store.save(this.isOnCall);
                this.isActive = false;
            },
            showPopper() {
                this.isActive = true;
                if (this.popper) {
                    this.$nextTick(() => {
                        this.popper.forceUpdate();
                    });
                    return;
                }
                this.$nextTick(() => {
                    this.popper = createPopper(this.$refs.button, this.$refs.modal, {
                        placement: 'bottom-start',
                        modifiers: [
                            {
                                name: 'offset',
                                options: {
                                    offset: [0, 8],
                                },
                            },
                        ],
                    });
                });
            },
        },
        beforeDestroy() {
            if (this.popper) {
                this.popper.destroy();
            }
        }
    }
</script>
