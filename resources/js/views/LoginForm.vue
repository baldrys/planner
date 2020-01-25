<template>
    <div>
        <div class="container">
            <div class="row mt-5">
                <div class="col-4 offset-4">
                    <h1>Вход</h1>
                    <div v-if="isUserJustRegistered" class="alert alert-success" role="alert">
                        Вы успешно зарегистрировались!
                    </div>
                    <ErrorMessage v-if="hasError" :error="error" />
                </div>
                <div class="col-4 offset-4">
                    <div class="form-group">
                        <label for="email">Почта</label>
                        <input 
                            v-model="username" 
                            type="email"
                            class="form-control" 
                            :class="{'is-invalid': ($v.username.$dirty && !$v.username.required) || ($v.username.$dirty && !$v.username.email)}"
                            name="email" 
                            id="email" 
                            aria-describedby="emailHelp">
                        <div v-if="$v.username.$dirty && !$v.username.required" class="alert alert-danger">Пожалуйста введите email </div>
                        <div v-else-if="$v.username.$dirty && !$v.username.email" class="alert alert-danger">Пожалуйста введите корректный email </div>
                    </div>
                </div>
                <div class="col-4 offset-4">
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input 
                            v-model="password" 
                            name="password" 
                            type="password" 
                            class="form-control" 
                            :class="{'is-invalid': $v.password.$dirty && !$v.password.required}"
                            id="password">
                        <div v-if="$v.password.$dirty && !$v.password.required" class="alert alert-danger">Пожалуйста введите пароль </div>

                    </div>
                </div>
                <div class="col-4 offset-4">
                    <button type="submit" class="btn btn-primary btn-form-size" @click="login" :disabled="isLoading">
                        <div class="button__inner">
                            <div v-if="isLoading" class="button__spiner">
                                <div class="loadingio-spinner-dual-ring-4yp7ndn2wh"><div class="ldio-8eipe7qgbqw">
                                <div></div><div><div></div></div>
                                </div></div>
                            </div>
                            <div class="button__login-text">Вход</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ErrorMessage from "../components/errorMessage";
    import {email, required} from "vuelidate/lib/validators"
    export default {
        name: "LoginForm",
        components: { ErrorMessage },
        data() {
            return {
                username: '',
                password: '',
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
                if(this.$v.$invalid) {
                    this.$v.$touch();
                    console.log("INVALID");
                    return
                };
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
                return this.$store.getters['auth/error'];
            },
            isLoading() {
                return this.$store.getters['auth/isLoading']
            },
        },
        validations: {
            username: {email, required},
            password: {required},
        }
    }
</script>

<style>
    body {
        background: rgb(206, 206, 255); 
        font-family: 'Roboto Condensed', sans-serif;
        font-family: 'Roboto', sans-serif;
    }

</style>