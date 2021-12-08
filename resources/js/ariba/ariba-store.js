import axios from 'axios';

class AribaStore {
    constructor(url) {
        this.hello = 'World';
        this.url = url;
        this.items = [];
        this.loaded = false;
        this.updating = false;
        this.refresh();
    }

    delete(item) {
        if (!item.id) {
            return;
        }
        this.commit(item.id, {
            "_action": "delete"
        });
    }

    save(item) {
        this.commit(item.id || null, {
            ref: item.ref,
            description: item.description,
        });
    }

    refresh() {
        this.commit();
    }

    commit(id, data) {
        let props = {
            method: 'get',
            url: (id) ? this.url + '/' + id : this.url
        };
        if (data) {
            props.method = 'post';
            props.data = data;
        }
        this.updating = true;
        let that = this;
        axios(props)
            .then(function (response) {
                that.applyState(response);
            })
            .catch(that.apiError);
    }

    applyState(response) {
        this.items = response.data;
        this.loaded = true;
        this.updating = false;
    }

    apiError(error) {
        console.log('AribaStore.apiError()');
        console.log(error.response);
        console.log(error);
    }
}

export default AribaStore;
