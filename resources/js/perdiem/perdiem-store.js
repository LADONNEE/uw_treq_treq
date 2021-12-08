import axios from "axios";

class PerdiemStore {
    constructor(stateUri) {
        this.stateUri = stateUri;
        this.days = null;
        this.nights = null;
        this.mealsPd = null;
        this.lodgingPd = null;
        this.lodging = null;
        this.loaded = false;
        this.refresh();
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
        this.days = response.data.days;
        this.nights = response.data.nights;
        this.mealsPd = response.data.meals_pd;
        this.lodgingPd = response.data.lodging_pd;
        this.lodging = response.data.lodging;
        this.loaded = true;
    }

    apiError(error) {
        console.log('PerdiemStore.apiError()');
        console.log(error.response);
        console.log(error);
    }
}

export default PerdiemStore;
