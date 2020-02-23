<template>
<div class="personal-info">
    <div v-if="isAuthLoading || isUserLoading" class="spinner-border spinner"></div>
        <div v-else class="p-3 border-bottom">
        <div v-if="isUserJustUpdated" class="alert alert-success" role="alert">
            Информация успешно обновлена!
        </div>
        <h1 class="h2">Персональная информация</h1>
        <div class="form-group row">
            <label for="username-input" class="col-2 col-form-label">Никнейм</label>
            <div class="col-4">
                <input class="form-control" type="text" v-model="user.name" id="username-input"
                :class="{'is-invalid': !($v.user.name.required && $v.user.name.minLength)}">
                <div v-if="!$v.user.name.required" class="alert alert-danger">Пожалуйста введите никнейм</div>
                <div v-else-if="!$v.user.name.minLength" class="alert alert-danger">Длинна никнейма должна быть больше 6 символов</div>
            </div>
        </div>
        <div class="form-group row">
            <label for="email-input" class="col-2 col-form-label">Почта</label>
            <div class="col-4">
                <input class="form-control" type="email" v-model="user.email" id="email-input"
                :class="{'is-invalid': !($v.user.email.required && $v.user.email.email)}">
                <div v-if="!$v.user.email.required" class="alert alert-danger">Пожалуйста введите email</div>
                <div v-else-if="!$v.user.email.email" class="alert alert-danger">Пожалуйста введите корректный email</div>
            </div>
        </div>
        <div class="form-group row">
            <label for="password-input" class="col-2 col-form-label">Пароль</label>
            <div class="col-4">
                <input type="password" class="form-control"  v-model="user.password" id="password-input">
                <div v-if="!isUserJustUpdated && $v.user.password.$dirty && !$v.user.password.required" class="alert alert-danger">Пожалуйста введите пароль</div>
                <div v-else-if="$v.user.password.$dirty &&!$v.user.password.minLength" class="alert alert-danger">Длинна пароля должна быть больше 6 символов</div>
                <ErrorMessage v-if="hasAuthError" :error="authError" />
                <ErrorMessage v-if="hasUserError" :error="userError" />
            </div>
        </div>
        <div><a @click="toggleSetNewPassowrd" data-toggle="collapse" href="#collapseExample">Изменить пароль</a></div>
        <div class="collapse"  id="collapseExample">
            <div class="form-group row">
                <label for="newPassword-input" class="col-2 col-form-label">Новый пароль</label>
                <div class="col-4">
                    <input type="password" class="form-control" v-model="user.newPassword" id="newPassword-input">
                    <div v-if="!isUserJustUpdated && setNewPassword && $v.user.newPassword.$dirty && !$v.user.newPassword.required" class="alert alert-danger">Пожалуйста введите пароль</div>
                    <div v-if="setNewPassword && $v.user.newPassword.$dirty && !$v.user.newPassword.minLength" class="alert alert-danger">Длинна пароля должна быть больше 6 символов</div>
                </div>
            </div>
        </div>

        <button @click="changeUser" :disabled="isUserLoading" type="button" class="btn btn-dark">
            <span v-if="isUserLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Изменить
        </button>
    </div>

</div>
</template>

<script>
    import ErrorMessage from "../components/errorMessage";
    import {email, required, minLength} from "vuelidate/lib/validators"
    export default {
        name: "PersonalInfo",
        components: { ErrorMessage },
        data(){
            return {
                user: {
                    name: null,
                    email: null,
                    password: null,
                    newPassword: null
                },
                isUserJustUpdated: false,
                setNewPassword: false
            }
        },
        methods: {
            toggleSetNewPassowrd() {
                if (this.setNewPassword === false) {
                    this.setNewPassword = true;
                } else {
                    this.setNewPassword = false;
                    this.user.newPassword = null
                }
            },
            changeUser() {
                this.isUserJustUpdated =  false;
                if(this.$v.$invalid) {
                    this.$v.$touch();
                    return
                };
                const userFromStore = this.userFromStore;
                const payload = {
                    username: userFromStore.email,
                    password: this.user.password
                };
                this.$store.dispatch('auth/login', payload).then(
                    () => {
                        if (this.hasAuthError) {
                            console.log(this.authError)
                        } else {
                            this.updateUser();
                        }
                    }
                );
            },
            updateUser() {
                const payload = {
                    name: this.user.name,
                    password: this.setNewPassword ? this.user.newPassword : this.user.password,
                    email: this.user.email
                };
                this.$store.dispatch('user/update', payload).then(
                    () => {
                        if (this.hasUserError) {
                            console.log(this.userError)
                        } else {
                            this.isUserJustUpdated = true;
                            this.user.password = null;
                            this.user.newPassword = null;
                        }
                    }
                );
            }
        },
        created() {
            if(this.isAuthenticated){
                this.$store.dispatch('auth/getUserInfo').then(
                    () => {
                        if (this.hasError) {
                            console.log(this.error)
                        } else {
                            const userFromStore = this.userFromStore;
                            this.user = {
                                name: userFromStore.name,
                                email: userFromStore.email,
                                password: '',
                                newPassword: ''
                            }

                        }
                    }
                );
            } else {
                this.$router.push({ name: "LoginForm"});
            }
        },
        computed: {
            userFromStore() {
                return this.$store.getters['auth/getUser']
            },
            isAuthenticated() {
                return this.$store.getters['auth/isAuthenticated'];
            },
            userDataIschanged() {
                const oldUserData = this.userFromStore;
                return (this.user.name != oldUserData.name)||(this.user.email != oldUserData.email);
            },
            isAuthLoading() {
               return this.$store.getters['auth/isLoading']
            },
            isUserLoading() {
                return this.$store.getters['user/isLoading']
            },
            passwordsAreEqueals() {
                return true;
            },
            hasUserError() {
                    return this.$store.getters['user/hasError'];
                },
            userError() {
                return this.$store.getters['user/error']
            },
            hasAuthError() {
                    return this.$store.getters['auth/hasError'];
                },
            authError() {
                return this.$store.getters['auth/error']
            },
        },
        // validations: {
        //     user: {
        //         name: {required, minLength: minLength(6)},
        //         password: {required, minLength: minLength(6)},
        //         newPassword: {  required: (function () {
        //             return this.setNewPassword
        //         }), minLength: minLength(6)},
        //         email: {email, required},
        //     }
        // }
        validations() {
                if(this.setNewPassword){
                    return {
                        user: {
                            name: {required, minLength: minLength(6)},
                            password: {required, minLength: minLength(6)},
                            newPassword: { required, minLength: minLength(6)},
                            email: {email, required},
                        }
                    }                
                } else {
                    return {
                        user: {
                            name: {required, minLength: minLength(6)},
                            password: {required, minLength: minLength(6)},
                            email: {email, required},
                        }
                    }   
                }

            }
    }
</script>

<style>
</style>