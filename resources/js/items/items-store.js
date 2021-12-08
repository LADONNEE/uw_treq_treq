import axios from "axios";

class ItemsStore {
    constructor(stateUri, taxRate) {
        this.stateUri = stateUri;
        this.items = [];
        this.lastKey = 0;
        this.taxRate = taxRate;
        this.refresh();
    }

    generateKeys() {
        for (let i = 0; i < this.items.length; ++i) {
            this.items[i].key = ++ this.lastKey;
        }
    }

    new() {
        return {
            id: null,
            name: '',
            url: '',
            qty: 1,
            amount: '',
            action: null
        };
    }

    addTax() {
        return {
            id: null,
            name: 'Tax',
            url: '',
            qty: 1,
            amount: '',
            total: this.total(),
            taxRate: this.taxRate,
            action: null
        };
    }

    save(item) {
        if (!item.key) {
            this.create(item);
        } else {
            this.update(item);
        }
    }

    create(item) {
        this.items.push({
            id: null,
            name: item.name || 'New Item',
            url: item.url || '',
            qty: this.safeQty(item.qty),
            amount: this.formatAmount(item.amount),
            action: 'save',
            key: ++ this.lastKey
        });
    }

    total() {
        let tot = 0.0;
        for (let i = 0; i < this.items.length; ++i) {
            if (this.items[i].qty && this.items[i].amount && this.items[i].action !== 'delete') {
                tot = tot + (parseInt(this.items[i].qty) * parseFloat(this.items[i].amount));
            }
        }
        return tot;
    }

    update(item) {
        const key = Math.floor(item.key);
        if (key === 0 || key > this.lastKey) {
            return;
        }
        for (let i = 0; i < this.items.length; ++i) {
            if (this.items[i].key === key) {
                this.items[i].name = item.name || 'New Item';
                this.items[i].url = item.url || '';
                this.items[i].qty = this.safeQty(item.qty);
                this.items[i].amount = this.formatAmount(item.amount);
                this.items[i].action = 'save';
            }
        }
    }

    formatAmount(amount) {
        if (!amount || isNaN(amount)) {
            return 0.00;
        }
        return (amount * 1.0).toFixed(2);
    }

    safeQty(input) {
        if (!input || isNaN(input)) {
            return 1;
        }
        const i = parseInt(input, 10);
        return (i) ? i : 1;
    }

    delete(key) {
        key = Math.floor(key);
        if (key === 0 || key > this.lastKey) {
            return;
        }
        for (let i = 0; i < this.items.length; ++i) {
            if (this.items[i].key === key) {
                this.items[i].action = 'delete';
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
        this.items = response.data;
        this.lastKey = 0;
        this.generateKeys();
    }

    apiError(error) {
        console.log('ItemsStore.apiError()');
        console.log(error.response);
        console.log(error);
    }
}

export default ItemsStore;
