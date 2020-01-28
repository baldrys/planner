<template>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link :to="{ name: 'home'}" active-class="nav-link">
                        Главная
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{ name: 'RegisterForm'}" class="nav-link">
                        Регистрация
                    </router-link>
                </li>
                <li v-if="!isAuthenticated" class="nav-item">
                    <router-link :to="{ name: 'LoginForm'}" class="nav-link">
                        Вход
                    </router-link>
                </li>
                <!-- <li class="nav-item">
                    <router-link :to="{ name: 'RegisterForm'}" active-class="nav-link">
                        Выход
                    </router-link>
                </li> -->
            </ul>

            <ul v-if="isAuthenticated" class="navbar-nav nav-bar-right">
                <li class="nav-item">
                    <span class="navbar-text"> {{ user.name }}</span>
                </li>

                <li class="nav-item">
                    <a href="#" @click="logout" class="nav-link">
                        Выход
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    computed: {
        isAuthenticated() {
            return this.$store.getters['auth/isAuthenticated'];
        },
        isAuthenticated() {
            return this.$store.getters['auth/isAuthenticated'];
        },
        // isAdmin() {
        //     return this.$store.getters['user/hasRole']('ROLE_ADMIN');
        // },
        user() {
            return this.$store.getters['auth/getUser'];
        },
    },
    methods: {
        logout(){
            this.$store.dispatch('auth/logout').then(
                () => {
                    if (!this.hasError) {
                        this.$router.push({ name: "LoginForm"});
                    } else {
                    if (!this.hasError)
                        console.log(this.error)
                    }
                }
            );
        }
    }
}
</script>

<style>

</style>