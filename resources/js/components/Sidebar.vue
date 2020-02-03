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
    </nav>
</template>

<script>
export default {
    name: "Sidebar",
    mounted() {
        this.resizeRightBorder('sidebar')
    },
    methods:{
        resizeRightBorder(elem) {
            const SIZE_TO_HIDE = 200;
            const HIDDEN_BORDER_WIDTH = 2;
            const elementInDom = document.getElementsByClassName(elem)[0];
            const nav = elementInDom.firstChild;
            let borderDiv = document.createElement("div");
            borderDiv.className = "sidebar-border";
            const mouseUp = function(e) {
                document.removeEventListener("mousemove", mouseMove);
                window.removeEventListener("mouseup", mouseUp);
                const resizedWidth = e.clientX - elementInDom.offsetLeft;
                if(resizedWidth <= SIZE_TO_HIDE){

                    elementInDom.style.width = `${HIDDEN_BORDER_WIDTH}px`;
                } 
            };
            const mouseMove = function(e) {
                const resizedWidth = e.clientX - elementInDom.offsetLeft;
                if(resizedWidth > SIZE_TO_HIDE && nav.style.visibility == "hidden"){
                    nav.style.visibility = "visible";
                } 
                if(resizedWidth <= SIZE_TO_HIDE && nav.style.visibility != "hidden"){
                    nav.style.visibility = "hidden";
                } 
                elementInDom.style.width = `${resizedWidth}px`;
            };

            borderDiv.addEventListener("mousedown", function (e) {
                const rightBorder = (elementInDom.offsetLeft + parseInt(window.getComputedStyle(elementInDom).getPropertyValue("width")));
                window.addEventListener("mouseup", mouseUp);
                document.addEventListener("mousemove", mouseMove);
            });
            elementInDom.appendChild(borderDiv);

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