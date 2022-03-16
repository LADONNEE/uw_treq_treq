<template>
    <spotlight-box>
        <div class="item-edit__tax">
            <div class="item-edit__name">
                <input-block :input="inputs.name">
                    <input-text :input="inputs.name"
                                @keydown="handleKeydown"></input-text>
                </input-block>
            </div>
            <div class="item-edit__subtotal">
                <input-block :input="inputs.subtotal">
                    <input-text :input="inputs.subtotal"
                                @keydown="handleKeydown"></input-text>
                </input-block>
            </div>
            <div class="item-edit__rate">
                <input-block :input="inputs.rate">
                    <input-text :input="inputs.rate"
                                @keydown="handleKeydown"></input-text>
                </input-block>
            </div>
            <div class="item-edit__amount">
                <input-block :input="inputs.amount">
                    <input-text :input="inputs.amount"
                                @keydown="handleKeydown"></input-text>
                </input-block>
            </div>
        </div>
        <div class="item-edit__help text-muted text-med mb-3">
            Tax Rate can be modified or Amount (Subtotal + Tax) can be directly entered if needed.
        </div>
        <div class="item-edit__buttons">
            <button class="btn btn-primary" @click.prevent="save">Save</button>
            <button class="btn btn-secondary" @click.prevent="cancel">Cancel</button>
        </div>
    </spotlight-box>
</template>

<script>
import twoDecimalPlaces from "../utilities/two-decimal-places";
import InputBlock from "../forms/InputBlock";
import InputModel from "../forms/input-model";
import InputText from "../forms/InputText";
import randomString from "../utilities/random-string";
import SpotlightBox from '../components/SpotlightBox';
export default {
    props: ['props'],
    data() {
        const idSuffix = randomString();
        return {
            subId: 'sub_' + idSuffix,
            inputs: {
                name: new InputModel({
                    id: 'name_' + idSuffix,
                    name: 'name',
                    label: 'Item',
                    value: this.props.name
                }),
                subtotal: new InputModel({
                    id: 'subtotal_' + idSuffix,
                    name: 'subtotal',
                    label: 'Sub Total',
                    value: twoDecimalPlaces(this.props.total)
                }),
                rate: new InputModel({
                    id: 'rate_' + idSuffix,
                    name: 'rate',
                    label: 'Tax Rate',
                    value: this.props.taxRate
                }),
                amount: new InputModel({
                    id: 'amount_' + idSuffix,
                    name: 'amount',
                    label: 'Amount',
                    value: this.computeAmount(this.props.total, this.props.taxRate)
                }),
            }
        }
    },
    watch: {
        subtotal(val) {
            this.inputs.amount.value = this.computeAmount(val, this.inputs.rate.value);
        },
        rate(val) {
            this.inputs.amount.value = this.computeAmount(this.inputs.subtotal.value, val);
        },
    },
    computed: {
        subtotal() {
            return this.inputs.subtotal.value;
        },
        rate() {
            return this.inputs.rate.value;
        }
    },
    methods: {
        save() {
            this.$emit('save', {
                name: this.inputs.name.value,
                amount: this.inputs.amount.value
            });
        },
        cancel() {
            this.$emit('cancel');
        },
        computeAmount(subtotal, rate) {
            subtotal = parseFloat(subtotal);
            rate = parseFloat(rate);
            if (subtotal && rate) {
                return twoDecimalPlaces(subtotal * rate);
            }
            return '0.00';
        },
        handleKeydown(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                e.preventDefault();
                this.save();
            }
            if (e.key === 'Escape' || e.keyCode === 27) {
                e.preventDefault();
                this.cancel();
            }
        },
    },
    components: {
        InputBlock,
        InputText,
        SpotlightBox
    }
}
</script>
