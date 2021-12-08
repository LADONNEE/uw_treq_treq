<template>
    <collapsing-container
        :expanded="expanded"
        :collapsed-text="task.name"
        :response-type="task.responseType"
        @expand="() => this.expanded = true"
    >
        <div class="task__name pointer" @click="expanded = false">{{ task.name }}</div>
        <section class="request">
            <div class="text-sm-bold">{{ task.createdAt }}</div>
            <div>{{ task.taskSummary }}</div>
            <div v-if="task.description" class="quote">{{ task.description }}</div>
        </section>
        <section class="response">
            <div class="text-sm-bold">{{ task.completedAt }}</div>
            <div>{{ task.responseSummary }}{{ task.behalf }}</div>
            <div v-if="task.message" class="quote">{{ task.message }}</div>
        </section>
        <section>
            <task-actions
                :save="save"
                :id="task.id"
                :is-approval="task.isApproval"
                :can-complete="task.canComplete"
                :can-reassign="task.canReassign"
                :can-delete="task.canDelete"
            ></task-actions>
        </section>
    </collapsing-container>
</template>

<script>
    import CollapsingContainer from "./CollapsingContainer";
    import TaskActions from "./TaskActions";
    export default {
        props: [ 'task', 'save', 'open' ],
        data() {
            return {
                expanded: this.open || !this.task.isComplete
            }
        },
        components: {
            CollapsingContainer,
            TaskActions
        }
    }
</script>
