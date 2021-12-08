<template>
    <div>
        <approval-item v-for="approval in approvals"
                       :approval="approval"
                       :can-edit="canEdit"
                       :key="approval.id"
        ></approval-item>
    </div>
</template>

<script>
    import ApprovalItem from './ApprovalItem';
    export default {
        props: {
            canEdit: {
                type: Boolean,
                default: true
            }
        },
        data() {
            return {
                approvals: window.__state_approvals || []
            }
        },
        components: {
            'approval-item': ApprovalItem
        }
    }
</script>