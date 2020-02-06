<template>
    <div class="d-flex flex-column min-vh-100">
        <Navbar/>
        <div class="d-flex flex-grow-1">
            <Sidebar/>
            <main role="main" class="flex-grow-1">
                <slot/>
            </main> 
        </div>
    </div>
</template>

<script>
    import Sidebar from '../components/Sidebar'
    import Navbar from '../components/Navbar'

    export default {
        name: "Default",
        components: {
            Sidebar,
            Navbar
        }
    }
</script>

<style>


</style>