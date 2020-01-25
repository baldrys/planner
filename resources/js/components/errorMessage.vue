<template>
    <div class="alert alert-danger">
        {{ error.response.data.message }}
        <div v-for="(value, key) in dataErrors" :key="key">
            {{ value[0] }}
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErrorMessage",
        props: {
            error: {
                type: Error,
                required: true
            }
        },
        computed: {
            dataErrors() {
                return this.error.response.data.errors
            }
        }
    }
</script>

<style scoped>

</style>