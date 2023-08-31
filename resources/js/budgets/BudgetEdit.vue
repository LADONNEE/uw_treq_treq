<template>
    <spotlight-box>
        <!-- <div class="row">
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Search Worktag (or Budget Nr)</label>
                    <budget-suggest :focused="focus === 'budgetno'"
                                    v-model="budgetno"
                                    :placeholderName="'CC000123 (or 00-0000)'"
                                    :widthField="'8rem'"
                                    @selected="(option) => budgetSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></budget-suggest>
                </div>
            </div>
            <!-- <div class="col-md-auto">
                <div class="form-group">
                    <label>Name</label>
                    <budget-suggest :focused="false"
                                    v-model="name"
                                    :placeholderName="'Name of Budget'"
                                    :widthField="'20rem'"
                                    @selected="(option) => budgetSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></budget-suggest>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>PCA Code</label>
                    <input type="text" class="form-control" style="width:12rem;"
                           v-model="pca_code"
                           @keydown="keyHandler($event)"
                           ref="pca_code">
                </div>
            </div>
            
        </div> -->
        <div class="row">
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Budget Number (legacy)</label>
                    <budget-suggest 
                                    v-model="budgetno"
                                    :placeholderName="'00-0000'"
                                    :widthField="'8rem'"
                                    @selected="(option) => budgetSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></budget-suggest>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Cost Center</label>
                    <worktag-suggest :focused="false"
                                    v-model="wd_costcenter"
                                    :ref="wd_costcenter"
                                    :placeholderName="'CC000123'"
                                    @selected="(option) => worktagSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></worktag-suggest>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Program</label>
                    <worktag-suggest :focused="false"
                                    v-model="wd_program"
                                    :placeholderName="'PG000123'"
                                    @selected="(option) => worktagSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></worktag-suggest>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Standalone Grant</label>
                    <input type="text" class="form-control"
                        :focused="false"
                        v-model="wd_standalonegrant"
                        :placeholder="'( free text )'"
                        @keydown="keyHandler($event)"
                     />
                    
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Grant</label>
                    <worktag-suggest :focused="false"
                                    v-model="wd_grant"
                                    :placeholderName="'GR000123'"
                                    @selected="(option) => worktagSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></worktag-suggest>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Gift</label>
                    <worktag-suggest :focused="false"
                                    v-model="wd_gift"
                                    :placeholderName="'GF000123'"
                                    @selected="(option) => worktagSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></worktag-suggest>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Fund</label>
                    <input type="text" class="form-control"
                        :focused="false"
                        v-model="wd_fund"
                        :placeholder="'( free text )'"
                        @keydown="keyHandler($event)"
                     />
                    
                </div>
            </div>
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Assignee</label>
                    <input type="text" class="form-control"
                        :focused="false"
                        v-model="wd_assignee"
                        :placeholder="'( free text )'"
                        @keydown="keyHandler($event)"
                     />
                    
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-auto">
                <div class="form-group">
                    <label>Split</label>
                    <input type="text" class="form-control" style="width:8rem;"
                           v-model="split"
                           @keydown="keyHandler($event)"
                           ref="split">
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
    import WorktagSuggest from '../budgets/WorktagSuggest';
    import SpotlightBox from '../components/SpotlightBox';
    export default {
        props: ['budget', 'focus'],
        data() {
            return {
                budgetno: '',
                name: '',
                pca_code: '',

                wd_costcenter: '',
                wd_program: '',
                wd_standalonegrant: '',
                wd_grant: '',
                wd_assignee: '',
                wd_gift: '',
                wd_fund: '',

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

            this.wd_costcenter = this.budget.wd_costcenter;
            this.wd_program = this.budget.wd_program;
            this.wd_standalonegrant = this.budget.wd_standalonegrant;
            this.wd_grant = this.budget.wd_grant;
            this.wd_assignee = this.budget.wd_assignee;
            this.wd_gift = this.budget.wd_gift;
            this.wd_fund = this.budget.wd_fund;



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
                /*this.$refs.split.focus();
                this.$refs.split.select();*/
                this.validate();
            },
            worktagSelected(option) {
                if (!option) {
                    return;
                }
                //this.wd_costcenter = option.workday_code;
                console.log("WORKTAG SUGGESTION");
                /*console.log(event.target);
                console.log(option.workday_code);*/
                //this.$refs.theInput.value = option.workday_code;
                /*this.$refs.split.focus();
                this.$refs.split.select();*/
                this.validate();
            },
            keyHandler(event) {
                if (event.key === 'Enter' || event.keyCode === 13) {
                    this.saveBudget();
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
                    wd_costcenter: this.wd_costcenter,
                    wd_program: this.wd_program,
                    wd_standalonegrant: this.wd_standalonegrant,
                    wd_grant: this.wd_grant,
                    wd_assignee: this.wd_assignee,
                    wd_gift: this.wd_gift,
                    wd_fund: this.wd_fund,
                    pca_code: this.pca_code,
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
                if ( !this.wd_costcenter &&  (!this.budgetno || !this.budgetno.match(/^[0-9][0-9]\-?[0-9]{4}$/ ))   ) {
                    this.isInvalid = true;
                    this.validMessage = 'At least a Cost center or a Budget number is required.';
                }
            }
        },
        watch: {
            budgetno() {
                this.validate();
            },
            split() {
                if (this.split_type && String(this.split).indexOf('$') > -1) {
                    this.split_type = 'A';
                } else if (this.split_type && String(this.split).indexOf('%') > -1) {
                    this.split_type = 'P';
                } else if (!this.split_type || String(this.split).indexOf('*') > -1) {
                    this.split_type = 'R';
                }
            }
        },
        components: {
            BudgetHelp,
            BudgetSuggest,
            WorktagSuggest,
            SpotlightBox
        }
    }
</script>
