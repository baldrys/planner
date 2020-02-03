<template>
    <nav class="sidebar bg-secondary">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active text-light" href="#">
                    Персональная информация
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="#">
                    Активности
                </a>
            </li>
        </ul>
        <div @mousedown="borderClicked" class="sidebar-border"></div>
    </nav>
</template>

<script>
export default {
    name: "Sidebar",
    data() {
        return {
            sizeToHide: 150,
            minSidebarWidth: 2
        }
    },
    methods:{
        getSidebarElement(){
            return document.getElementsByClassName('sidebar')[0]
        },
        mouseUp(e) {
            document.removeEventListener("mousemove", this.mouseMove);
            window.removeEventListener("mouseup", this.mouseUp);
            const sidebar = this.getSidebarElement();
            const resizedWidth = e.clientX - sidebar.offsetLeft;
            const nav = sidebar.firstChild;
            if(resizedWidth <= this.sizeToHide){
                sidebar.style.width = `${this.minSidebarWidth}px`;  
                nav.style.visibility = 'hidden';
            } else
                nav.style.visibility = 'visible';
        },
        borderClicked(e) {
            window.addEventListener("mouseup", this.mouseUp);
            document.addEventListener("mousemove", this.mouseMove);
        },
        mouseMove(e) {
            const sidebar = this.getSidebarElement();
            const resizedWidth = e.clientX - this.getSidebarElement().offsetLeft;
            sidebar.style.width = `${resizedWidth}px`;
            this.sideBarWidth = resizedWidth;
        },
    }
}
</script>

<style>

    .sidebar{
        position:relative;
        /* min-width: 150px; */
        max-width: 300px;
    }

    .sidebar-border {
        position: absolute;
        cursor: e-resize;
        width: 5px;
        right: -5px;
        top: 0;
        height: 100%;
        /* background-color: rgb(0, 0, 0); */
    }

</style>