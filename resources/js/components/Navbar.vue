<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link :to="{ name: 'home'}" active-class="nav-link text-light">
                        Главная
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{ name: 'RegisterForm'}" class="nav-link text-light">
                        Регистрация
                    </router-link>
                </li>
                <li v-if="!isAuthenticated" class="nav-item">
                    <router-link :to="{ name: 'LoginForm'}" class="nav-link text-light">
                        Вход
                    </router-link>
                </li>
            </ul>

            <ul v-if="isAuthenticated" class="navbar-nav nav-bar-right">
                <li class="nav-item">
                    <router-link :to="{ name: 'personal'}" class="nav-link text-light">
                        <i class="material-icons align-middle">
                            person_outline
                        </i>
                        <span class="align-middle">{{ userFromStore.name }}</span>
                     </router-link>
                </li>
                <li class="nav-item">
                    <a href="#" @click="logout" class="nav-link text-light">
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
        userFromStore(){
            return this.$store.getters['auth/getUser'];
        } 
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