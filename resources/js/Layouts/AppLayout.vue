<template>
    <div>

        <Head :title="title" />

        <main id="main" class="main">
            <slot></slot>
        </main>


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

    })
</script>
