<template>
    <div class="notification is-danger">
        <!-- {{ error.response.data.message }} -->
        ОШИБКА
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
        }
    }
</script>

<style scoped>

</style>