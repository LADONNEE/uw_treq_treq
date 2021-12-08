<template>
    <i :class="cssClasses"></i>
</template>

<script>
    export default {
        props: ['name'],
        computed: {
            cssClasses() {
                let out = {
                    fas: true
                };
                out['fa-' + this.name] = true;
                return out;
            }
        }
    }
</script>