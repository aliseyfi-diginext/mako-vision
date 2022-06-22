<template>
    <dashboard title="Mako-Vision Control Panel">

        <div class="tile">
            <div class="d-flex justify-content-between">
                <h4> محتوای فایل {{target}} </h4>
                <div>
                    <button type="button" class="btn btn-outline-primary btn-lg mx-1" @click="historyBack">
                        <i class="bi bi-arrow-right m-0"></i>
                    </button>

                    <button type="button" class="btn btn-outline-primary btn-lg mx-1" @click="download">
                        <i class="bi bi-download m-0"></i>
                    </button>

                    <button type="button" class="btn btn-outline-primary btn-lg mx-1" @click="copyContent">
                        <i class="bi bi-clipboard m-0"></i>
                    </button>

                    <button type="button" class="btn btn-outline-danger btn-lg mx-1" @click="destroy">
                        <i class="bi bi-trash m-0"></i>
                    </button>

                </div>
            </div>
        </div>
        <div class="tile">
            <pre>{{contents}}</pre>
        </div>

    </dashboard>
</template>

<script>
    import { defineComponent } from 'vue'
    import Dashboard from '@/Layouts/Dashboard.vue'

    export default defineComponent({
        props : ['target', 'contents'],
        components: {
            Dashboard
        },
        data : function () {
            return {
            }
        },
        methods : {
            copyContent : function () {
                this.copyToClipboard(this.contents);
            },
            download : function () {
                this.downloadData(this.contents, this.target);
            },
            destroy : function () {
                var url = route('jsons.destroy', this.target);
                var redirectURL = route('jsons');
                this.swalAreYouSure(url, [], -1, 'delete', redirectURL);
            }
        },
    })
</script>


<style scoped>



</style>
