<template>
    <div>
        <div class="form-group">
            <label for="name">Имя</label>
            <input v-model="username" class="form-control" id="name" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="email">Почта</label>
            <input v-model="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input v-model="password" type="password" class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary" @click="register">Отправить</button>
        <ErrorMessage v-if="hasError" :error="error" />
        <!-- <div v-if="hasError">ERROR</div> -->
    </div>
</template>

<script>
    import ErrorMessage from "../components/errorMessage";
    export default {
        name: "RegisterForm",
        components: { ErrorMessage },
        data() {
            return {
                username: null,
                email: null,
                password: null
            };
        },
        computed:{
            hasError() {
                    return this.$store.getters['user/hasError'];
                },
            error() {
                return this.$store.getters['user/error']
            }
        },
        methods: {
            register() {
                const payload = {
                    username: this.username,
                    email: this.email,
                    password: this.password
                };
                this.$store.dispatch('user/register', payload).then(
                    () => {
                        if (!this.hasError) {
                            this.$router.push({ name: "LoginForm", params: {userRegistered: true }});
                        } else {
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