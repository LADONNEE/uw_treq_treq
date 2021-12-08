<template>
    <div>
        <table class="items-list">
            <thead>
            <tr>
                <th style="width: 10%;">Qty</th>
                <th>Item</th>
                <th>URL</th>
                <th class="text-right" style="width: 20%;">Amount</th>
                <th class="text-right" style="width: 20%;">Line Total</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="item in store.items" :key="item.key" :class="{deleting: item.action === 'delete'}">
                <td class="editable">
                    <button-block @click="() => edit(item, 'qty')">{{ item.qty }}</button-block>
                </td>
                <td class="editable">
                    <button-block @click="() => edit(item, 'name')">{{ item.name }}</button-block>
                </td>
                <td class="items-list__url">
                    <external-link :link="item.url"></external-link>
                </td>
                <td class="editable items-list__amount">
                    <button-block @click="() => edit(item, 'amount')">
                        <span v-if="item.amount">{{ item.amount }}</span>
                        <span v-else class="empty">0.00</span>
                    </button-block>
                </td>
                <td class="text-right">{{ lineTotal(item) }}</td>
            </tr>

            </tbody>
        </table>
        <div class="mt-3">
            <button class="btn btn-secondary" @click.prevent="newItem">&plus; Item</button>
            <button class="btn btn-secondary" @click.prevent="addTax">&plus; Tax</button>
        </div>

        <item-edit
            v-if="editing"
            :qty="editing.qty"
            :name="editing.name"
            :amount="editing.amount"
            :url="editing.url"
            :focus="focus"
            @save="(item) => save(item)"
            @remove="(key) => remove(key)"
            @cancel="() => cancel()"
        ></item-edit>

        <tax-item
            v-if="addingTax"
            :props="addingTax"
            @save="(item) => saveTax(item)"
            @cancel="() => cancel()"
        ></tax-item>

        <input type="hidden" name="items_json" :value="itemsJson">
        <json-debug v-if="false" :data="store.items"></json-debug>
    </div>
</template>

<script>
    import dollarFormat from "../utilities/dollar-format";
    import ButtonBlock from "../components/ButtonBlock";
    import ExternalLink from "../components/ExternalLink";
    import ItemEdit from "./ItemEdit";
    import ItemsStore from "./items-store";
    import JsonDebug from "../components/JsonDebug";
    import TaxItem from "./TaxItem";
    export default {
        props: ['state-uri', 'taxRate'],
        data() {
            return {
                store: new ItemsStore(this.stateUri, this.taxRate),
                editing: null,
                addingTax: null,
                focus: ''
            };
        },
        methods: {
            addTax() {
                this.editing = null;
                this.addingTax = this.store.addTax();
            },
            lineTotal(item) {
                if (item.qty && item.amount) {
                    return dollarFormat(1.00 * item.qty * item.amount);
                }
                return '0.00';
            },
            edit(item, focus) {
                this.addingTax = null;
                this.focus = focus;
                this.editing = item;
            },
            save(data) {
                this.store.save({
                    id: this.editing.id,
                    key: this.editing.key,
                    name: data.name,
                    qty: data.qty,
                    amount: data.amount,
                    url: data.url
                });
                this.editing = null;
            },
            saveTax(data) {
                this.store.save({
                    id: null,
                    key: null,
                    name: data.name,
                    qty: 1,
                    amount: data.amount,
                    url: ''
                });
                this.addingTax = null;
            },
            cancel() {
                this.addingTax = null;
                this.editing = null;
            },
            newItem() {
                this.addingTax = null;
                this.editing = this.store.new();
            },
            remove() {
                this.store.delete(this.editing.key);
                this.editing = null;
            }
        },
        computed: {
            itemsJson() {
                return JSON.stringify(this.store.items);
            }
        },
        components: {
            ButtonBlock,
            ExternalLink,
            ItemEdit,
            JsonDebug,
            TaxItem
        }
    }
</script>
