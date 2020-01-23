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
                <p>Привет {{ username }}!</p>
            </div>
            <a class="button is-warning" href="/logout">
                <button type="button" class="btn btn-primary">Выход</button>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
        computed: {
            isAuthenticated() {
                return this.$store.getters['user/isAuthenticated'];
            },
            isUser() {
                return this.$store.getters['user/hasRole']('ROLE_USER');
            },
            // isAdmin() {
            //     return this.$store.getters['user/hasRole']('ROLE_ADMIN');
            // },
            username() {
                return this.isAuthenticated ? this.$store.state.security.user.username : null;
            }
        }
    }
</script>

<style>

</style>