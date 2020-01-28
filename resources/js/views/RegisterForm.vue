<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-4 offset-4">
                <h1>Регистрация</h1>
                <ErrorMessage v-if="hasError" :error="error" />
                <div class="form-group">
                    <label for="username">Имя</label>
                    <input 
                        v-model="username" 
                        class="form-control" 
                        :class="{'is-invalid': ($v.username.$dirty && !$v.username.required) || ($v.username.$dirty && !$v.username.minLength)}"
                        name="username" 
                        id="username">
                    <div v-if="$v.username.$dirty && !$v.username.required" class="alert alert-danger">Пожалуйста введите имя </div>
                    <div v-else-if="$v.username.$dirty && !$v.username.minLength" class="alert alert-danger">Минимальная длина имени 6 символов </div>
                </div>
                <div class="form-group">
                    <label for="email">Почта</label>
                    <input 
                        v-model="email" 
                        type="email"
                        class="form-control" 
                        :class="{'is-invalid': ($v.email.$dirty && !$v.email.required) || ($v.email.$dirty && !$v.email.email)}"
                        name="email" 
                        id="email" 
                        aria-describedby="emailHelp">
                    <div v-if="$v.email.$dirty && !$v.email.required" class="alert alert-danger">Пожалуйста введите email </div>
                    <div v-else-if="$v.email.$dirty && !$v.email.email" class="alert alert-danger">Пожалуйста введите корректный email </div>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input 
                        v-model="password" 
                        name="password" 
                        type="password" 
                        class="form-control" 
                        :class="{'is-invalid': ($v.password.$dirty && !$v.password.required) || ($v.password.$dirty && !$v.password.minLength)}"
                        id="password">
                    <div v-if="$v.password.$dirty && !$v.password.required" class="alert alert-danger">Пожалуйста введите пароль </div>
                    <div v-else-if="$v.password.$dirty && !$v.password.minLength" class="alert alert-danger">Минимальная длина пароля 6 символов </div>
                </div>
                <button class="btn btn-primary" type="button"  @click="register" :disabled="isLoading">
                    <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Зарегистрироваться
                </button>
            </div>
        </div>
    </div>

</template>

<script>
    import ErrorMessage from "../components/errorMessage";
    import {email, required, minLength} from "vuelidate/lib/validators"
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
                    return this.$store.getters['auth/hasError'];
                },
            error() {
                return this.$store.getters['auth/error']
            },
            isLoading() {
                return this.$store.getters['auth/isLoading']
            }
        },
        methods: {
            register() {
                if(this.$v.$invalid) {
                    this.$v.$touch();
                    return
                };
                const payload = {
                    username: this.username,
                    email: this.email,
                    password: this.password
                };
                this.$store.dispatch('auth/register', payload).then(
                    () => {
                        if (!this.hasError) {
                            this.$router.push({ name: "LoginForm", params: {userRegistered: true }});
                        } else {
                            console.log(this.error)
                        }
                    }
                );
            }
        },
        validations: {
            username: {required, minLength: minLength(6)},
            email: {required, email},
            password: {required, minLength: minLength(6)},
        }
    }
</script>

<style>

</style>