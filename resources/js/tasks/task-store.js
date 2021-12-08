import axios from 'axios';

class TaskStore {

    constructor(url) {
        this.url = url;
        this.tasks = [];
        this.loaded = false;
        this.refresh();
    }

    save(data) {
        let that = this;
        axios({
            method: 'post',
            url: this.url,
            data: data
        })
            .then(function(response) {
                that.refresh();
            })
            .catch(function(error) {
                that.apiError(error);
            });
    }

    wasSaved(response) {
        this.tasks.unshift(response.data);
    }

    refresh() {
        let that = this;
        axios({
            method: 'get',
            url: this.url
        })
            .then(function (response) {
                that.applyState(response);
            })
            .catch(function (response) {
                that.apiError(response);
            });
    }

    applyState(response) {
        this.tasks = response.data;
        this.loaded = true;
        let refreshBtn = document.getElementById('js-order-refresh');
        if (refreshBtn) {
            refreshBtn.click();
        }
    }

    apiError(error) {
        console.log('TaskStore.apiError()');
        console.log(error.response);
        console.log(error);
    }

}

export default TaskStore;
