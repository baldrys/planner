<template>
    <div>
        <div v-if="isUserJustREgistered" class="alert alert-success" role="alert">
            Вы успешно зарегистрировались!
        </div>
        <div class="form-group">
            <label for="email">Почта</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" id="password" >
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <ErrorMessage v-if="hasError" :error="error" />
        <div v-if="hasError">ERROR</div>
    </div>
</template>

<script>
    import ErrorMessage from "../components/errorMessage";

    export default {
        name: "LoginForm",
        props:{
            userRegistered: {
                type: Boolean,
            }
        },
        computed:{
            hasError() {
                    return this.$store.getters['user/hasError'];
                },
            error() {
                return this.$store.getters['user/error']
            }
        },
        data: function () {
            return {
                isUserJustREgistered: this.userRegistered
            }
        },
        components: { ErrorMessage },
            hasError() {
                return this.$store.getters['user/hasError'];
            },
            error() {
                return this.$store.getters['user/error']
            }
    }
</script>

<style>

</style>