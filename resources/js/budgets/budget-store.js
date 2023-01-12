import scrubFloat from "../utilities/scrub-float";
import axios from "axios";

class BudgetStore {
    constructor(stateUri) {
        this.stateUri = stateUri;
        this.budgets = [];
        this.lastKey = 0;
        this.loaded = false;
        this.refresh();
    }

    generateKeys() {
        this.sum = 0.0;
        for (let i = 0; i < this.budgets.length; ++i) {
            this.budgets[i].key = ++ this.lastKey;
        }
    }

    new() {
        return {
            id: null,
            budgetno: '',
            pca_code: '',
            project_code_id: null,
            opt_code: '',
            name: '',
            split_type: 'R',
            split: '',
            action: null
        };
    }

    save(budget) {
        if (!budget.key) {
            this.create(budget);
        } else {
            this.update(budget);
        }
    }

    create(budget) {
        this.budgets.push({
            id: null,
            budgetno: budget.budgetno || '00-0000',
            name: budget.name || 'New Item',
            pca_code: budget.pca_code || '',
            project_code_id: budget.project_code_id || null,
            opt_code: budget.opt_code || '',
            split_type: budget.split_type || 'R',
            split: scrubFloat(budget.split || ''),
            action: 'save',
            key: ++ this.lastKey
        });
    }

    update(budget) {
        const key = Math.floor(budget.key);
        if (key === 0 || key > this.lastKey) {
            return;
        }
        for (let i = 0; i < this.budgets.length; ++i) {
            if (this.budgets[i].key === key) {
                
                if(this.budgets[i].pca_code != budget.pca_code) {
                    //Update Task for correct PCA Code Authorizer
                    this.updateRelatedTask(this.budgets[i].order_id, this.budgets[i].pca_code, budget);
                }

                this.budgets[i].budgetno = budget.budgetno || '';
                this.budgets[i].pca_code = budget.pca_code || '';
                this.budgets[i].project_code_id = budget.project_code_id || '';
                this.budgets[i].opt_code = budget.opt_code || '';
                this.budgets[i].name = budget.name || 'New Item';
                this.budgets[i].split_type = budget.split_type || 'R';
                this.budgets[i].split = scrubFloat(budget.split || '');
                this.budgets[i].action = 'save';
                break;
            }
        }
    }


    updateRelatedTask(budgetOrderId, oldBudgetPcaCode, newBudget) {
        
        let that = this;
        axios({
            method: 'post',
            url: "/treq/api/tasks/" + budgetOrderId, //this.url,
            data: { 'action': 'budget-update', 'old_budget_pcacode': oldBudgetPcaCode , 'updated_budget': newBudget }
        })
        .catch(function(error) {
                that.apiError(error);
            });

        // .then(function(response) {
        //     that.refresh();
        // })
    }

    delete(key) {
        key = Math.floor(key);
        if (key === 0 || key > this.lastKey) {
            return;
        }
        for (let i = 0; i < this.budgets.length; ++i) {
            if (this.budgets[i].key === key) {
                this.budgets[i].action = 'delete';
            }
        }
    }

    refresh() {
        let that = this;
        axios({
            method: 'get',
            url: this.stateUri
        })
            .then(function (response) {
                that.applyState(response);
            })
            .catch(function (response) {
                that.apiError(response);
            });
    }

    applyState(response) {
        this.budgets = response.data;
        this.lastKey = 0;
        this.generateKeys();
        this.loaded = true;
    }

    apiError(error) {
        console.log('BudgetStore.apiError()');
        console.log(error.response);
        console.log(error);
    }



}

export default BudgetStore;
