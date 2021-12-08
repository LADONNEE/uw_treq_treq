<template>
    <div>
        <budget-list :store="store" @active="(active) => childActive(active)"></budget-list>

        <div class="note__row mt-3">
            <notes-section :id="order_id"
                           section="budget"
                           @active="(active) => childActive(active)"
            ></notes-section>
        </div>

        <step-finish :editing="editing"
                     step-name="Budgets"
                     step-value="budgets"
                     :continue-url="completeUrl"
        ></step-finish>
        <input type="hidden" name="budgets_json" :value="itemsJson">
        <json-debug v-if="false" :data="store.budgets"></json-debug>
    </div>
</template>

<script>
    import BudgetList from './BudgetList';
    import BudgetStore from './budget-store';
    import JsonDebug from '../components/JsonDebug';
    import NotesSection from '../notes/NotesSection';
    import StepFinish from '../components/StepFinish';
    export default {
        props: ['order_id', 'stateUri', 'completeUrl'],
        data() {
            return {
                store: new BudgetStore(this.stateUri),
                editing: false,
                saving: true,
            }
        },
        computed: {
            itemsJson() {
                return JSON.stringify(this.store.budgets);
            }
        },
        methods: {
            childActive(active) {
                this.editing = active;
            }
        },
        components: {
            BudgetList,
            JsonDebug,
            NotesSection,
            StepFinish
        }
    }
</script>
