<template>
    <div class="d-flex flex-grow-1">
        <Sidebar/>
        <main role="main" class="flex-grow-1">
            <div class="pt-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>
        </main> 
    </div>
</template>

<script>
    import Sidebar from '../components/Sidebar'
    export default {
        name: "Home",
        components: {
            Sidebar
        },
        created() {
            if(this.isAuthenticated){
                this.$store.dispatch('auth/getUserInfo').then(
                    () => {
                        if (this.hasError) {
                            console.log(this.error)
                        }
                    }
                );
            } else {
                this.$router.push({ name: "LoginForm"});
            }
        },
        computed: {
            isAuthenticated() {
                return this.$store.getters['auth/isAuthenticated'];
            },
            // isAdmin() {
            //     return this.$store.getters['user/hasRole']('ROLE_ADMIN');
            // },
            user() {
                return this.$store.getters['auth/getUser'];
            },
            hasError() {
                return this.$store.getters['auth/hasError'];
            },
            error() {
                return this.$store.getters['auth/error'];
            },
            isLoading() {
                return this.$store.getters['auth/isLoading']
            },
        },

    }
</script>

<style>


</style>