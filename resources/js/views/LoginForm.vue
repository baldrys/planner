<template>
    <div>
        <div v-if="isUserJustRegistered" class="alert alert-success" role="alert">
            Вы успешно зарегистрировались!
        </div>
        <div class="form-group">
            <label for="email">Почта</label>
            <input v-model="username" type="email" class="form-control" id="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input v-model="password" type="password" class="form-control" id="password" >
        </div>
        <button type="submit" class="btn btn-primary" @click="login">Submit</button>
        <ErrorMessage v-if="hasError" :error="error" />
    </div>
</template>

<script>
    import ErrorMessage from "../components/errorMessage";

    export default {
        name: "LoginForm",
        components: { ErrorMessage },
        data() {
            return {
                username: null,
                password: null,
                isUserJustRegistered: this.userRegistered ? true: false
            };
        },
        props:{
            userRegistered: {
                type: Boolean,
            }
        },
        methods:{
            login() {
                const payload = {
                    username: this.username,
                    password: this.password
                };
                this.$store.dispatch('auth/login', payload).then(
                    () => {
                        if (!this.hasError) {
                            this.$router.push({ name: "home"});
                        } else {
                            console.log(this.error)
                        }
                    }
                );
            }
        },
        computed:{
            hasError() {
                    return this.$store.getters['auth/hasError'];
                },
            error() {
                return this.$store.getters['auth/error']
            }
        }
    }
</script>

<style>

</style>