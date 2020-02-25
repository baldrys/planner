<template>
    <div class="flex-grow-1 d-flex">
        <Sidebar/>
        <main role="main" class="flex-grow-1">
            <slot/>
        </main> 
    </div>
</template>

<script>
    import Sidebar from '../components/Sidebar'

    export default {
        name: "Default",
        components: {
            Sidebar,
        }
    }
</script>

<style>


</style>