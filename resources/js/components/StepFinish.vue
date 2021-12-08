<template>
    <div class="row">
        <div class="col">
            <hr class="my-3">
            <input type="hidden" name="step" :value="stepValue">
            <div class="my-3">
                <div v-if="editing">
                    <p>Save changes before continuing</p>
                    <button class="btn btn-secondary" disabled><i class="fas fa-lock"></i> Continue</button>
                </div>
                <div v-else>
                    <p>Finished entering {{ stepName }}</p>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['editing', 'stepName', 'stepValue']
    }
</script>
