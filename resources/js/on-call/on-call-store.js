import axios from "axios";

class OnCallStore {
    constructor(url) {
        this.url = url;
        this.onCall = 0;
        this.updating = false;
        this.refresh();
    }

    refresh() {
        this.updating = true;
        let that = this;
        axios({
            method: 'get',
            url: this.url
        })
            .then((response) => this.onCall = response.data.on_call)
            .catch(that.apiError);
    }

    save(val) {
        this.updating = true;
        let that = this;
        axios({
            method: 'post',
            url: this.url,
            data: {
                on_call: val
            }
        })
            .then((response) => this.onCall = response.data.on_call)
            .catch(that.apiError);
    }

    apiError(error) {
        console.log('OnCallStore.apiError()');
        console.log(error.response);
        console.log(error);
    }
}

export default OnCallStore;
