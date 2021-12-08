<template>
    <div v-if="expanded" class="task task-card">
        <div class="task__icon">
            <i class="fas" :class="icon"></i>
        </div>
        <div class="task__body">
            <slot></slot>
        </div>
        <div class="task__collapse">
            <i class="fas fa-caret-up"></i>
        </div>
    </div>
    <div v-else class="task task-collapsed">
        <div class="task__icon">
            <i class="fas" :class="icon"></i>
        </div>
        <div class="task__body">
            <div class="task__name pointer" @click.prevent="expand">{{ collapsedText }}</div>
        </div>
        <div class="task__collapse">
            <i class="fas fa-caret-down"></i>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['responseType', 'expanded', 'collapsedText'],
        computed: {
            icon() {
                const approved = this.responseType === 'yes';
                const sentback = this.responseType === 'no';
                const completed = this.responseType === 'complete';
                return {
                    'fa-thumbs-up': approved,
                    'fa-undo': sentback,
                    'fa-check': completed,
                    'fa-question-circle': !approved && !sentback && !completed,
                    'text-danger': sentback,
                    'text-success': approved || completed,
                };
            }
        },
        methods: {
            expand() {
                this.$emit('expand');
            }
        }
    }
</script>
