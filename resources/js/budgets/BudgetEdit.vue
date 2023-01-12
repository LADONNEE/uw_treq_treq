<template>
    <spotlight-box>
        <div class="row">
            <div class="col-md-auto">
                <div class="form-group">
                    <label>PCA/Workday Description</label>
                    <!-- <input type="text" class="form-control" style="width:12rem;"
                           v-model="pca_code"
                           @keydown="keyHandler($event)"
                           ref="pca_code"> -->
                    <project-code-suggest :focused="focus === 'pca_code'"
                                    v-model="pca_code"
                                    ref="pca_code"
                                    @selected="(option) => projectCodeSelected(option)"
                    ></project-code-suggest>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>OPT</label>
                        <input type="text" class="form-control" style="width:5rem;"
                            maxlength="5"
                           v-model="opt_code"
                           @keydown="keyHandler($event)"
                           ref="opt_code">
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Budget Number</label>
                    <budget-suggest :focused="focus === 'budgetno'"
                                    v-model="budgetno"
                                    @selected="(option) => budgetSelected(option)"
                    ></budget-suggest>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Budget Name</label>
                    <input type="text" class="form-control" style="width:14rem;" placeholder="Name of Budget"
                           v-model="name"
                           @keydown="keyHandler($event)"
                           ref="name">
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Split Type</label>
                    <select class="form-control" v-model="split_type">
                        <option value="A">$ Dollar Amount</option>
                        <option value="P">% Percentage</option>
                        <option value="R">* Remainder</option>
                    </select>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Split</label>
                    <input type="text" class="form-control" style="width:8rem;"
                           v-model="split"
                           @keydown="keyHandler($event)"
                           ref="split">
                </div>
            </div>
        </div>
        <div  v-if="isInvalid" class="row">
            <div class="col text-danger mb-3 px-3">
                {{ validMessage }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-primary" @click.prevent="saveBudget()">Save</button>
                <button class="btn btn-secondary" v-if="isDeletable" @click.prevent="deleteBudget">Delete</button>
                <button class="btn btn-secondary" @click.prevent="cancel()">Cancel</button>
            </div>
        </div>
        <div class="row">
            <budget-help></budget-help>
        </div>
    </spotlight-box>
</template>

<script>
    import BudgetHelp from './BudgetHelp';
    import BudgetSuggest from '../budgets/BudgetSuggest';
    import ProjectCodeSuggest from '../budgets/ProjectCodeSuggest';
    import SpotlightBox from '../components/SpotlightBox';
    export default {
        props: ['budget', 'focus'],
        data() {
            return {
                budgetno: '',
                name: '',
                pca_code: '',
                opt_code: '',
                project_code_id: null,
                split_type: '',
                split: '',
                isDeletable: false,
                isInvalid: false,
                validMessage: ''
            };
        },
        mounted() {
            this.budgetno = this.budget.budgetno;
            this.name = this.budget.name;
            this.pca_code = this.budget.pca_code;
            this.opt_code = this.budget.opt_code;
            this.project_code_id = this.budget.project_code_id;
            this.split_type= this.budget.split_type;
            this.split = this.budget.split;
            this.isDeletable = !! this.budget.id;
            if (this.focus && this.$refs[this.focus] && typeof this.$refs[this.focus].focus === 'function') {
                let focused = this.$refs[this.focus];
                this.$nextTick(() => {
                    focused.focus();
                    focused.select();
                });
            }
        },
        methods: {
            budgetSelected(option) {
                if (!option) {
                    return;
                }
                this.budgetno = option.budgetno;
                this.name = option.name;
                this.$refs.split.focus();
                this.$refs.split.select();
                this.validate();
            },
            projectCodeSelected(option) {
                if (!option) {
                    return;
                }
                this.pca_code = 'Pca code: ['.concat((option.code === '' ? 'no code' : option.code),'] ', option.description,' ___ WORKDAY: [',option.workday_code,'] ', option.workday_description) ; //pca_code
                this.project_code_id = option.id;
                //this.name = option.name;
                this.$refs.opt_code.focus();
                this.$refs.opt_code.select();
                this.validate();
            },
            keyHandler(event) {
                if (event.key === 'Enter' || event.keyCode === 13) {
                    //this.saveBudget();
                }
                if (event.key === 'Escape' || event.keyCode === 27) {
                    this.cancel();
                }
            },
            saveBudget() {
                this.validate();
                if (this.isInvalid) {
                    return;
                }
                this.$emit('saved', this.getData());
                this.clear();
            },
            deleteBudget() {
                this.$emit('deleted', this.budget.key);
                this.clear();
            },
            getData() {
                return {
                    id: this.budget.id,
                    budgetno: this.budgetno,
                    name: this.name,
                    pca_code: this.pca_code,
                    opt_code: this.opt_code,
                    project_code_id: this.project_code_id,
                    split_type: this.split_type,
                    split: this.split,
                    key: this.budget.key
                };
            },
            cancel() {
                this.confirming = false;
                this.$emit('canceled');
            },
            clear() {
                this.budgetno = this.name = this.split = '';
                this.split_type = 'R';
            },
            validate() {
                this.isInvalid = false;
                this.validMessage = '';
                // if (!this.budgetno || !this.budgetno.match(/^[0-9][0-9]\-?[0-9]{4}$/)) {
                //     this.isInvalid = true;
                //     this.validMessage = 'Budget number (00-0000) is required.';
                // }
                if (!this.pca_code) {
                    this.isInvalid = true;
                    this.validMessage = 'PCA/Workday code or description is required.';
                }
                if (this.opt_code.length > 5) {
                    this.isInvalid = true;
                    this.validMessage = 'OPT code should be 5 characters or less';
                }
            }
        },
        watch: {
            budgetno() {
                this.validate();
            },
            split() {
                if (this.split_type && this.split.indexOf('$') > -1) {
                    this.split_type = 'A';
                } else if (this.split_type && this.split.indexOf('%') > -1) {
                    this.split_type = 'P';
                } else if (!this.split_type || this.split.indexOf('*') > -1) {
                    this.split_type = 'R';
                }
            }
        },
        components: {
            BudgetHelp,
            BudgetSuggest,
            ProjectCodeSuggest,
            SpotlightBox
        }
    }
</script>
