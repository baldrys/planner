<template>
    <div class="d-flex flex-column min-vh-100">
        <Navbar/>
        <slot/>  
    </div>

</template>

<script>
    import Navbar from '../components/Navbar'
    export default {
        name: "Auth",
        components: {
            Navbar
        }
    }
</script>

<style>

</style>