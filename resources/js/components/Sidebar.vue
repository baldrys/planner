<template>
    <nav class="sidebar">
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
            let borderDiv = document.createElement("div");
            borderDiv.className = "sidebar-border";
            const elementInDom = document.getElementsByClassName(elem)[0];

            const mouseUp = function() {
                document.removeEventListener("mousemove", mouseMove);
                window.removeEventListener("mouseup", mouseUp);
            };
            const mouseMove = function(e) {
                const elWidth = parseInt(window.getComputedStyle(elementInDom).getPropertyValue("width"));
                const offset = e.clientX - elementInDom.offsetLeft;
                elementInDom.style.width = `${offset}px`;
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