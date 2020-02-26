<template>
    <div class="container">
        <div class="row">
            <div v-if="isAdmin" class="col-4 offset-4">
                <p>Привет вы админ!</p>
            </div>
            <div v-else class="col-4 offset-4">
                <p>Привет вы не админ идите обратно!</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
        computed: {
            isAuthenticated() {
                return this.$store.getters['auth/isAuthenticated'];
            },
            isAdmin() {
                return this.$store.getters['auth/isAdmin'];
            },
            username() {
                return this.isAuthenticated ? this.$store.state.security.user.username : null;
            }
        }
    }
</script>

<style>

</style>