<template>
    <dashboard title="Mako-Vision Control Panel">

        <div class="tile">
            <h1 class="h4 mb-3"> فایل‌های موجود در سیستم </h1>
            <table class="table table-responsive-md table-striped table-bordered">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> <i class="bi bi-file-earmark-spreadsheet-fill text-primary ms-1"></i> نام فایل </th>
                        <th> <i class="bi bi-calendar-fill text-primary ms-1"></i> تاریخ </th>
                        <th> <i class="bi bi-clock-fill text-primary ms-1"></i> ساعت </th>
                        <th colspan="3"> <i class="bi bi-gear-fill text-primary ms-1"></i> عملیات </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item, i in list">
                        <th> {{i+1}} </th>
                        <td> {{item.fileName}} </td>
                        <td> {{pDate(item.date)}} </td>
                        <td> {{dTime(item.date)}} </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm mx-1" @click="openRoute('jsons.show', item.key)">
                                <i class="bi bi-eye"></i>
                                مشاهده
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm mx-1" @click="download(item.key)">
                                <i class="bi bi-download"></i>
                                دانلود
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-danger btn-sm mx-1" @click="destroy(i, item.key)">
                                <i class="bi bi-trash"></i>
                                حذف
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </dashboard>
</template>

<script>
    import { defineComponent } from 'vue'
    import Dashboard from '@/Layouts/Dashboard.vue'

    export default defineComponent({
        props : ['list'],
        components: {
            Dashboard
        },
        data : function () {
            return {

            }
        },
        methods : {
            download : function (target) {
                var url = route('jsons.download', target);
                axios.get(url).then(res => {
                    this.downloadData(JSON.stringify(res.data), target+'.json');
                });
            },
            destroy : function (index, target) {
                var url = route('jsons.destroy', target);
                this.swalAreYouSure(url, this.list, index);
            }
        }
    })
</script>


<style scoped>



</style>
