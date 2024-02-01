<template>
    <spotlight-box>
        <div class="row">
            <div class="col-md-3">
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
            <div class="col-md-5">
                <div class="form-group">
                    <label>Worktag easy search</label>
                    <worktagtree-suggest :focused="false"
                                    v-model="worktag_easysearch"
                                    :widthField="'16rem'"
                                    :placeholderName="'type here'"
                                    @selected="(option) => worktagtreeSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></worktagtree-suggest>
                </div>
            </div>
        </div>

        <hr />


        <div class="row">
            <div class="col-md-6">
                <div class="form-group worktag-field">
                    
                    <div class="row">
                        <div class="col-md-4">
                    <label>Cost Center</label>
                        </div>
                        <div class="col-md-8">

                    <worktag-suggest :focused="false"
                                    v-model="wd_costcenter"
                                    :placeholderName="'CC000123'"
                                    @selected="(option) => worktagSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></worktag-suggest>
                </div>
            </div>
                    
                </div>
                <div class="form-group worktag-field">
                    
                    <div class="row">
                        <div class="col-md-4">
                    <label>Program</label>
                        </div>
                        <div class="col-md-8">

                    <worktag-suggest :focused="false"
                                    v-model="wd_program"
                                    :placeholderName="'PG000123'"
                                    @selected="(option) => worktagSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></worktag-suggest>
                </div>
            </div>
                    
                </div>
                <div class="form-group worktag-field">
                    
                    <div class="row">
                        <div class="col-md-4">
                    <label>Grant</label>
                        </div>
                        <div class="col-md-8">

                    <worktag-suggest :focused="false"
                                    v-model="wd_grant"
                                    :placeholderName="'GR000123'"
                                    @selected="(option) => worktagSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></worktag-suggest>
                </div>
            </div>
                    
                </div>
                <div class="form-group worktag-field">
                    
                    <div class="row">
                        <div class="col-md-4">
                    <label>Gift</label>
                        </div>
                        <div class="col-md-8">

                    <worktag-suggest :focused="false"
                                    v-model="wd_gift"
                                    :placeholderName="'GF000123'"
                                    @selected="(option) => worktagSelected(option)"
                                    @keydown="keyHandler($event)"
                    ></worktag-suggest>
                </div>
                        
            </div>
                    
                </div>
                <div class="form-group worktag-field">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <label>Fund</label>
            </div>
                        <div class="col-md-8">

                            <worktag-suggest :focused="false"
                                            v-model="wd_fund"
                                            :placeholderName="'FD000123'"
                                            @selected="(option) => worktagSelected(option)"
                        @keydown="keyHandler($event)"
                            ></worktag-suggest>
                        </div>
                    </div>
                    
                </div>
                



            </div>

            

            
        </div>


        <hr />

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
    import WorktagtreeSuggest from '../budgets/WorktagtreeSuggest';
    import SpotlightBox from '../components/SpotlightBox';
    export default {
        props: ['budget', 'focus'],
        data() {
            return {
                budgetno: '',
                name: '',
                pca_code: '',
                
                worktag_easysearch: '',

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
            worktagtreeSelected(option) {
                if (!option) {
                    return;
                }
                //this.wd_costcenter = option.workday_code;
                console.log("WORKTAG SUGGESTION");
                //Parse option into array
                //Delete existing choices:

                this.wd_costcenter = "";
                this.wd_program = "";
                this.wd_grant = "";
                this.wd_gift = "";
                this.wd_fund = "";

                var optionsArray = option.name.replace("a!/^/!a", "").split("b!/^/!b");

                console.log(optionsArray);
                optionsArray.forEach((worktagCombi) => {
                    console.log(worktagCombi);

                    var worktag = worktagCombi.split("c!/^/!c");
                    console.log("worktag after split");
                    console.log(worktag);

                    switch (worktag[0].substring(0, 2).toUpperCase()) {
                    case 'CC':
                        this.wd_costcenter = worktag[0];
                        break;
                    case 'PG':
                        this.wd_program = worktag[0];
                        break;
                    case 'GR':
                        this.wd_grant = worktag[0];
                        break;
                    case 'GF':
                        this.wd_gift = worktag[0];
                        break;
                    case 'FD':
                        this.wd_fund = worktag[0];
                        break;                    
                    default:
                        console.log(`Couldn't map ${worktag[0]}.`);
                    }

                    this.worktag_easysearch = '';

                });
                


                /*this.wd_costcenter = option.workday_code;
                this.wd_program = option.workday_code;*/
                /*console.log(event.target);
                console.log(option.workday_code);*/
                //this.$refs.theInput.value = option.workday_code;
                /*this.$refs.split.focus();
                this.$refs.split.select();*/
                //this.validate();
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
                if ( (!this.wd_costcenter || this.wd_costcenter.length < 6 ) &&  (!this.budgetno || !this.budgetno.match(/^[0-9][0-9]\-?[0-9]{4}$/ ))   ) {
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
            WorktagtreeSuggest,
            SpotlightBox
        }
    }
</script>
