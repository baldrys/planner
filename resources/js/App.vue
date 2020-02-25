<template>
    <div class="min-vh-100 d-flex flex-column">
        <Navbar/>
        <component :is="layout">
            <router-view/>
        </component>
    </div>
</template>

<script>
    import Navbar from './components/Navbar'
    export default {
        name: 'app',
        components: {
            Navbar
        },
        computed: {
            layout() {
                return this.$route.meta.layout || 'default-layout'
            }
        },
        watch: {
            $route: {
                immediate: true,
                handler(to, from) {
                    document.title = to.meta.title || 'Some Default Title';
                }
            },
        }
    }
</script>

<style>
    .spinner{
        position: fixed;
        top: 50%;
        right: 50%;
    } 
</style>