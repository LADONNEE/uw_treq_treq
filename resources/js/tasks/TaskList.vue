<template>
    <div class="task-list">
        <task-item
            v-for="task in store.tasks"
            :key="task.id"
            :task="task"
            :save="saveTask"
        ></task-item>
        <approval-create v-if="mode ==='approval'" :save="saveTask" @closed="closeForm"></approval-create>
        <task-create v-if="mode ==='task'" :save="saveTask" @closed="closeForm"></task-create>
        <div v-if="!mode">
            <button class="btn btn-light" @click="mode = 'task'">&plus; Task</button>
            <button class="btn btn-light" @click="mode = 'approval'">&plus; Request Approval</button>
        </div>
        <json-debug v-if="false" :data="store.tasks"></json-debug>
    </div>
</template>

<script>
    import ApprovalCreate from "./ApprovalCreate";
    import JsonDebug from "../components/JsonDebug";
    import TaskCreate from "./TaskCreate";
    import TaskItem from "./TaskItem";
    import TaskStore from "./task-store";
    export default {
        props: ['url'],
        data() {
            return {
                store: new TaskStore(this.url),
                mode: null,
            };
        },
        methods: {
            saveTask(data) {
                this.store.save(data);
            },
            closeForm() {
                this.mode = null;
            }
        },
        components: {
            ApprovalCreate,
            JsonDebug,
            TaskCreate,
            TaskItem
        }
    }
</script>
