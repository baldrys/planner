<template>
    <div class="vertical-center">
        <div class="container" >
            <div class="row">
                <div class="col-4 offset-4 p-3" style="background-color: #e3f2fd;">
                    <h1>Вход</h1>
                    <div v-if="isUserJustRegistered" class="alert alert-success" role="alert">
                        Вы успешно зарегистрировались!
                    </div>
                    <ErrorMessage v-if="hasError" :error="error" />
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
                    <button class="btn btn-primary" type="button"  @click="login" :disabled="isLoading">
                        <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Вход
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

</style>