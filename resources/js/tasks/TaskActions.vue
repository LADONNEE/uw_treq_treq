<template>
    <div v-if="active">
        <component
            v-if="actionComponent"
            v-bind:is="actionComponent"
            @closed="closeForm"
            @confirmed="(data) => saveTask(data)"
        ></component>
        <div v-else>
            <button v-if="canComplete" v-for="btn in buttons" :class="btn.btnClass" @click.prevent="mode = btn.mode" >
                <i v-if="btn.icon" :class="btn.icon"></i> {{ btn.text }}
            </button>
            <button v-if="canReassign" class="btn btn-text ml-2" @click.prevent="mode = 'reassign'">Reassign</button>
            <button v-if="canDelete" class="btn btn-text ml-2" @click.prevent="mode = 'delete'">Delete...</button>
        </div>
    </div>
</template>

<script>
    import ApprovalApprove from "./ApprovalApprove";
    import ApprovalSendBack from "./ApprovalSendBack";
    import TaskComplete from "./TaskComplete";
    import TaskDelete from "./TaskDelete";
    import TaskReassign from "./TaskReassign";
    export default {
        props: ['id', 'canComplete', 'canDelete', 'canReassign', 'save', 'isApproval'],
        data() {
            return {
                mode: null
            };
        },
        computed: {
            buttons() {
                if (this.isApproval) {
                    return [
                        {
                            mode: 'approve',
                            text: 'Approve',
                            btnClass: 'btn btn-primary ml-2',
                            icon: 'fas fa-thumbs-up',
                        },
                        {
                            mode: 'send-back',
                            text: 'Send Back',
                            btnClass: 'btn btn-light ml-2',
                            icon: 'fas fa-undo',
                        },
                    ];
                }
                return [
                    {
                        mode: 'complete',
                        text: 'Complete',
                        btnClass: 'btn btn-primary ml-2',
                        icon: 'fas fa-check',
                    },
                ];
            },
            active() {
                return this.canComplete || this.canDelete;
            },
            actionComponent() {
                switch (this.mode) {
                    case 'approve': return 'ApprovalApprove';
                    case 'send-back': return 'ApprovalSendBack';
                    case 'complete': return 'TaskComplete';
                    case 'delete': return 'TaskDelete';
                    case 'reassign': return 'TaskReassign';
                    default: return null;
                }
            }
        },
        methods: {
            closeForm() {
                this.mode = null;
            },
            saveTask(data) {
                data.task_id = this.id;
                this.save(data);
            }
        },
        components: {
            ApprovalApprove,
            ApprovalSendBack,
            TaskComplete,
            TaskDelete,
            TaskReassign
        }
    }
</script>
