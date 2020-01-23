<template>
    <div>
        <div v-if="!isAuthenticated" class="navbar-item">
            <router-link v-if="!isAuthenticated" :to="{ name: 'LoginForm' }" class="button is-warning">
                <button type="button" class="btn btn-primary">Вход</button>
            </router-link>
            <router-link v-if="!isAuthenticated" :to="{ name: 'RegisterForm' }" class="button is-warning">
                <button type="button" class="btn btn-primary">Регистрация</button>
            </router-link>
        </div>

        <div v-if="isAuthenticated" class="navbar-item">
            <div>
                <p>Привет!</p>
            </div>
            <button type="button" class="btn btn-primary" @click="logout">Выход</button>
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
            // isAdmin() {
            //     return this.$store.getters['user/hasRole']('ROLE_ADMIN');
            // },
            username() {
                return this.isAuthenticated ? this.$store.state.security.user.username : null;
            }
        },
        methods: {
            logout(){
                this.$store.dispatch('auth/logout').then(
                    () => {
                        // if (!this.hasError) {
                        //     this.$router.push({ name: "home"});
                        // } else {
                        if (!this.hasError)
                            console.log(this.error)
                        // }
                    }
                );
            }
        }
    }
</script>

<style>

</style>