<template>
    <dashboard title="Mako-Vision Control Panel">

        <div class="tile">
            <div class="list">
                <h1 class="h4"> فایل‌های موجود در سیستم </h1>
                <hr>
                <div v-for="item in list" class="item" :class="item.key == target ? 'active' : ''">
                    <span> <i class="bi bi-file-earmark-spreadsheet-fill"></i> {{item.fileName}} </span>
                    <span> <i class="bi bi-calendar-fill"></i> {{pDate(item.date)}} </span>
                    <span> <i class="bi bi-clock-fill"></i> {{dTime(item.date)}} </span>
                    <hr>
                    <button type="button" class="btn btn-outline-dark btn-sm mx-1" @click="openRoute('jsons', item.key)">
                        <i class="bi bi-eye"></i>
                        مشاهده
                    </button>
                    <button type="button" class="btn btn-outline-dark btn-sm mx-1" @click="download(item.key)">
                        <i class="bi bi-download"></i>
                        دانلود
                    </button>
                </div>
            </div>
        </div>

        <div class="tile mt-4" v-if="contents">
            <div class="d-flex justify-content-between">
                <h4> محتوای فایل {{target}} </h4>
                <div>
                    <button type="button" class="btn btn-outline-dark mx-1" @click="save">
                        <i class="bi bi-clipboard m-0"></i>
                    </button>
                    <button type="button" class="btn btn-outline-dark mx-1" @click="download">
                        <i class="bi bi-download m-0"></i>
                    </button>
                </div>
            </div>
            <hr>
            <pre>{{contents}}</pre>
        </div>

    </dashboard>
</template>

<script>
    import { defineComponent } from 'vue'
    import Dashboard from '@/Layouts/Dashboard.vue'

    export default defineComponent({
        props : ['list', 'contents', 'target'],
        components: {
            Dashboard
        },
        data : function () {
            return {

            }
        },
        methods : {
            save : function () {
                var contents = JSON.stringify(this.contents);
                this.copyToClipboard(contents);
            },
            download : function (target=null) {
                if (!target) {
                    target = this.target;
                }
                var url = route('jsons.download', target);
                axios.get(url).then(res => {
                    this.downloadData(JSON.stringify(res.data), target+'.json');
                });
            }
        }
    })
</script>


<style scoped>

    .list > .item {
        border: 2px solid #62868A;
        display: inline-block;
        padding: 10px 25px;
        border-radius: 10px;
        margin: 20px;
    }

    .list > .item.active {
        transform: scale(1.1);
    }

    .list > .item > span {
        display: block;
        margin: 5px 0;
        color: #62868A;
    }

    .list > .item i {
        font-size: 1.25rem;
        margin-left: 5px;
    }

</style>
