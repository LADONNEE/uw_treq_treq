<template>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">{{ prefix }}</div>
        </div>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: ['prefix']
    }
</script>
