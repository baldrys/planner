<template>
    <div>
        <Navbar/>
        <!-- Отборажает нужную вьюху -->
        <router-view/>
    </div>
</template>

<script>
    import Navbar from './components/Navbar'

    export default {
        name: 'app',
        components: {
            Navbar
        }
    }
</script>