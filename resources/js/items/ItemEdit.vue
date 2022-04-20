<template>
    <spotlight-box>
        <div class="item-edit">
            <div class="item-edit__qty">
                <input-block :input="inputs.qty">
                    <input-text :input="inputs.qty"
                                :focus="focus === 'qty'"
                                @keydown="handleKeydown"></input-text>
                </input-block>
            </div>
            <div class="item-edit__name">
                <input-block :input="inputs.name">
                    <input-text :input="inputs.name"
                                :focus="focus === 'name'"
                                @keydown="handleKeydown"></input-text>
                </input-block>
            </div>
            <div class="item-edit__amount">
                <input-block :input="inputs.amount">
                    <input-text :input="inputs.amount"
                                :focus="focus === 'amount'"
                                @keydown="handleKeydown"></input-text>
                </input-block>
            </div>
            <div class="item-edit__sub">
                <div class="form-group">
                    <label class="form-group__label" :for="subId">Line Total</label>
                    <input class="form-control input-readonly" type="text" readonly :id="subId" :value="sub">
                </div>
            </div>
            <div class="item-edit__url">
                <input-block :input="inputs.url">
                    <input-text :input="inputs.url"
                                :focus="focus === 'url'"
                                @keydown="handleKeydown"></input-text>
                    <template v-slot:help>(Optional) Provide a link to a specific item to purchase</template>
                </input-block>
            </div>
            <div class="item-edit__buttons">
                <button class="btn btn-primary" @click.prevent="save">Save</button>
                <button class="btn btn-secondary" @click.prevent="remove">Delete</button>
                <button class="btn btn-secondary" @click.prevent="cancel()">Cancel</button>
            </div>
        </div>
    </spotlight-box>
</template>

<script>
    import dollarFormat from "../utilities/dollar-format";
    import InputBlock from "../forms/InputBlock";
    import InputModel from "../forms/input-model";
    import InputText from "../forms/InputText";
    import randomString from "../utilities/random-string";
    import SpotlightBox from '../components/SpotlightBox';
    export default {
        props: ['name', 'qty', 'amount', 'url', 'focus'],
        data() {
            const idSuffix = randomString();
            return {
                subId: 'sub_' + idSuffix,
                inputs: {
                    qty: new InputModel({
                        id: 'qty_' + idSuffix,
                        name: 'qty',
                        label: 'Qty',
                        value: this.qty
                    }),
                    name: new InputModel({
                        id: 'name_' + idSuffix,
                        name: 'name',
                        label: 'Item',
                        value: this.name
                    }),
                    amount: new InputModel({
                        id: 'amount_' + idSuffix,
                        name: 'amount',
                        label: 'Amount',
                        value: this.amount
                    }),
                    url: new InputModel({
                        id: 'url_' + idSuffix,
                        name: 'url',
                        label: 'URL',
                        value: this.url
                    }),
                }
            }
        },
        computed: {
            sub() {
                if (this.inputs.qty.value && this.inputs.amount.value) {
                    return dollarFormat(1.00 * this.inputs.qty.value * this.inputs.amount.value);
                }
                return '0.00';
            }
        },
        watch: {
            name(val) {
                this.inputs.name.value = val;
            },
            qty(val) {
                this.inputs.qty.value = val;
            },
            amount(val) {
                this.inputs.amount.value = val;
            },
            url(val) {
                this.inputs.url.value = val;
            },
        },
        methods: {
            save() {
                this.$emit('save', {
                    name: this.inputs.name.value,
                    url: this.inputs.url.value,
                    qty: this.inputs.qty.value,
                    amount: this.inputs.amount.value
                });
            },
            remove() {
                this.$emit('remove');
            },
            cancel() {
                this.$emit('cancel');
            },
            handleKeydown(e) {
                /*if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    this.save();
                }
                if (e.key === 'Escape' || e.keyCode === 27) {
                    e.preventDefault();
                    this.cancel();
                }*/
            },
        },
        components: {
            InputBlock,
            InputText,
            SpotlightBox
        }
    }
</script>
