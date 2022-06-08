<template>
    <div>

        <Head :title="title" />

        <div class="body">

            <aside>
                <ul>
                    <li :class="active('home')" @click="openRoute('home')">
                        <i class="bi bi-grid"></i>
                        <span> داشبورد </span>
                    </li>
                    <li :class="active('jsons')" @click="openRoute('jsons')">
                        <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                        <span> فایل‌های JSON </span>
                    </li>
                </ul>
            </aside>

            <main>

                <slot></slot>

            </main>

        </div>

    </div>
</template>

<script>

    import { defineComponent } from 'vue'
    import { Head } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Head
        },

        methods : {
            active : function (name) {
                return route().current(name) ? 'active' : '';
            }
        }

    })
</script>


<style scoped>

    .body {
        display: flex;
        height: 100vh;
        background-color: #F5F5F5;
        padding: 25px;
    }

    aside {
        width: 300px;
        background-color: #fcfcfc;
        border-radius: 15px;
        box-shadow: 4px 4px 8px #ccc;
    }

    aside > ul {
        list-style: none;
        padding: 0;
    }

    aside > ul > li {
        padding: 15px 25px;
        display: flex;
        align-items: center;
        cursor: pointer;
        border-right: 5px solid #fcfcfc;
        transition: .2s;
    }

    aside > ul > li:first-of-type {
        border-top-right-radius: 15px;
        border-top-left-radius: 15px;
    }

    aside > ul > li.active {
        color: #62868A;
        font-weight: bold;
        border-right-color: #62868A;
    }

    aside > ul > li:hover {
        background-color: #62868A;
        color: #fcfcfc;
        border-right-color: #62868A;
    }


    aside > ul > li > i {
        margin-left: 10px;
        font-size: 1.5rem;
    }

    main {
        overflow-y: auto;
        flex-grow: 1;
        padding: 0 25px;
    }

</style>
