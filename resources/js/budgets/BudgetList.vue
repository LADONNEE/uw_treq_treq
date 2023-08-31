<template>
    <div>
        <table class="budget-list table-tight mt-3">
            <thead>
            <tr>
                <th style="width:20%;">Budget Number (FAS)</th>
                <th>Worktags</th>
                <th style="width:15%;">PCA Code</th>
                <th style="width:15%;" class="text-right pr-3">Split</th>
            </tr>
            </thead>

            <tbody v-if="isEditable">
            <tr v-for="budget in store.budgets"
                :key="budget.id"
                :class="{deleting: budget.action === 'delete'}"
            >
                <td class="editable">
                    <button-block @click="editMe(budget, 'budgetno')">{{ budget.budgetno }}</button-block>
                </td>

                <td class="editable">
                    <button-block class="worktag" @click="editMe(budget, 'worktags')">
                        <span v-if="budget.wd_costcenter">{{ budget.wd_costcenter }}</span>
                        <span v-if="budget.wd_program">{{ budget.wd_program }}</span>
                        <span v-if="budget.wd_standalonegrant">{{ budget.wd_standalonegrant }}</span>
                        <span v-if="budget.wd_grant">{{ budget.wd_grant }}</span>
                        <span v-if="budget.wd_gift">{{ budget.wd_gift }}</span>
                        <span v-if="budget.wd_fund">{{ budget.wd_fund }}</span>
                        </button-block>
                </td>
                <td class="editable">
                    <button-block @click="editMe(budget, 'pca_code')">{{ budget.pca_code }}</button-block>
                </td>
                <td class="editable text-right pr-3">
                    <button-block @click="editMe(budget, 'split')">{{ formatSplit(budget.split, budget.split_type) }}</button-block>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="contains-button">
                    <button class="btn btn-text" @click.prevent="addBudget">&plus; Budget</button>
                </td>
            </tr>
            </tbody>

            <tbody v-else>
            <tr v-for="budget in store.budgets" :key="budget.id">
                <td>{{ budget.budgetno }}</td>
                <td class="worktag">
                    <span v-if="budget.wd_costcenter">{{ budget.wd_costcenter }}</span>
                    <span v-if="budget.wd_program">{{ budget.wd_program }}</span>
                    <span v-if="budget.wd_standalonegrant">{{ budget.wd_standalonegrant }}</span>
                    <span v-if="budget.wd_grant">{{ budget.wd_grant }}</span>
                    <span v-if="budget.wd_gift">{{ budget.wd_gift }}</span>
                    <span v-if="budget.wd_fund">{{ budget.wd_fund }}</span>
                </td>
                <td>{{ budget.pca_code }}</td>
                <td>{{ formatSplit(budget.split, budget.split_type) }}%</td>
            </tr>
            <tr>
                <td colspan="4" class="contains-button">
                    <button class="btn btn-text disabled">&plus; Budget</button>
                </td>
            </tr>
            </tbody>

        </table>

        <budget-edit v-if="showEditing"
                     :budget="editing"
                     :focus="focus"
                     @canceled="() => handleCanceled()"
                     @deleted="(data) => handleDeleted(data)"
                     @saved="(data) => handleSaved(data)">
        </budget-edit>
    </div>
</template>

<script>
    import ButtonBlock from "../components/ButtonBlock";
    import BudgetEdit from './BudgetEdit';
    import dollarFormat from "../utilities/dollar-format";
    import percentFormat from "../utilities/percent-format";
    export default {
        props: ['store'],
        data() {
            return {
                showEditing: false,
                editing: null,
                focus: 'budgetno'
            };
        },
        computed: {
            hasNoBudgets() {
                return this.store.loaded && this.store.budgets.length === 0;
            },
            showButtons() {
                return !this.showEditing;
            },
            isEditable() {
                return {
                    'is-editable': ! this.showEditing
                }
            }
        },
        watch: {
            hasNoBudgets(val) {
                if (val) {
                    this.addBudget();
                }
            },
            showEditing(val) {
                this.$emit('active', val);
            }
        },
        methods: {
            addBudget() {
                this.focus = 'budgetno';
                this.editing = this.store.new();
                this.showEditing = true;
            },
            editMe(budget, focus) {
                this.editing = budget;
                this.focus = focus;
                this.showEditing = true;
            },
            handleCanceled() {
                this.showEditing = false;
            },
            handleDeleted(data) {
                this.store.delete(data);
                this.showEditing = false;
            },
            handleSaved(data) {
                this.store.save(data);
                this.showEditing = false;
            },
            formatSplit(value, type) {
                if (type === 'R') {
                    return '* Remainder';
                }
                if (!value) {
                    return '';
                }
                if (type === 'A') {
                    return dollarFormat(value);
                }
                if (type === 'P') {
                    return percentFormat(value);
                }
                return '' + value + ' ' + type;
            }
        },
        components: {
            BudgetEdit,
            ButtonBlock
        }
    }
</script>

<style scoped>
    .contains-button {
        padding: 0;
    }
    .contains-button button.btn-text {
        padding: .5rem;
    }

    .worktag span{
        border: 1px solid;
        border-radius: 3px;
        padding: 4px;
        background: rgba(180, 167, 200, 0.5);
    }
</style>
