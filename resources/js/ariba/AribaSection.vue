<template>
    <section class="ariba">
        <div class="ariba__item" v-for="item in store.items" :key="item.id">
            <button class="ariba__ref" @click="edit(item)">{{ item.ref }}</button>
            <div class="ariba__description">
                {{ item.creator }}
                <span class="mx-2" style="color:#ccc;">|</span>
                {{ item.createdAt }}
                <span v-if="item.description" class="mx-2" style="color:#ccc;">|</span>
                {{ item.description }}
            </div>
        </div>
        <div v-if="editing" class="ariba__form">
            <div class="form-group">
                <label class="form-group__label">Ref#</label>
                <input ref="ariba" type="text" class="form-control" v-model="ref" maxlength="100" placeholder="Add Ref#" />
            </div>

            <div class="form-group">
                <label class="form-group__label">Description</label>
                <input type="text" class="form-control" maxlength="200" v-model="description" />
            </div>

            <div v-if="mode === 'save' && id">
                <button class="btn btn-primary" @click="save">Save</button>
                <button class="btn btn-secondary" @click="mode = 'deleting'">Delete...</button>
                <button class="btn btn-secondary" @click="editing = false">Cancel</button>
            </div>
            <div v-else-if="mode === 'deleting'">
                <div class="mb-2">
                    <input type="checkbox" class="float-left mt-1" v-model="deleteConfirmed" id="ariba__confirm-delete">
                    <label for="ariba__confirm-delete" class="ml-3">Confirm delete "{{ ref }}"</label>
                </div>
                <div>
                    <button class="btn btn-danger" :disabled="!deleteConfirmed" @click="doDelete">Delete!</button>
                    <button class="btn btn-secondary" @click="cancelDelete">Cancel</button>
                </div>
            </div>
            <div v-else>
                <button class="btn btn-primary" @click="save">Save</button>
                <button class="btn btn-secondary" @click="editing = false">Cancel</button>
            </div>
        </div>
        <div v-else class="ariba__form">
            <input v-if="canEdit" type="text" class="form-control" placeholder="Add Ref#" @focus="newItem" />
        </div>
    </section>
</template>

<script>
    import AribaStore from "./ariba-store";

    export default {
        props: ['url', 'canEdit'],
        data() {
            return {
                store: new AribaStore(this.url),
                editing: false,
                mode: 'save',
                deleteConfirmed: false,
                id: null,
                ref: '',
                description: '',
            }
        },
        methods: {
            edit(item) {
                if (!this.canEdit) {
                    return;
                }
                this.id = item.id;
                this.ref = item.ref;
                this.description = item.description;
                this.editing = true;
                this.mode = 'save';
                this.deleteConfirmed = false;
                this.$nextTick(function() {
                    this.$refs.ariba.focus();
                    this.$refs.ariba.select();
                });
            },
            newItem() {
                this.id = null;
                this.ref = '';
                this.description = '';
                this.editing = true;
                this.mode = 'save';
                this.deleteConfirmed = false;
                this.$nextTick(function() {
                    this.$refs.ariba.focus();
                });
            },
            save() {
                this.store.save({
                    id: this.id,
                    ref: this.ref,
                    description: this.description
                });
                this.editing = false;
            },
            cancelDelete() {
                this.mode = 'save';
                this.deleteConfirmed = false;
            },
            doDelete() {
                if (this.id && this.deleteConfirmed) {
                    this.store.delete({
                        id: this.id
                    });
                    this.editing = false;
                }
            }
        }
    }
</script>
