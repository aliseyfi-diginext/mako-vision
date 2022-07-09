<template>
    <dashboard title="Mako-Vision Control Panel">

        <div class="tile">
            <div class="text-center">
                <button type="button" class="btn btn-lg mx-1" :class="folder == 'health' ? 'btn-dark' : 'btn-outline-dark'"
                @click="openRoute('jsons', 'health')">
                    <i class="bi bi-heart-pulse-fill"></i> Health
                </button>
                <button type="button" class="btn btn-lg mx-1" :class="folder == 'barcodes' ? 'btn-dark' : 'btn-outline-dark'"
                @click="openRoute('jsons', 'barcodes')">
                    <i class="bi bi-file-break-fill"></i> Barcodes
                </button>
            </div>
            <hr>
            <div class="d-flex justify-content-around">
                <h1 class="h4 mb-3"> فایل‌های موجود در سیستم </h1>
                <button type="button" v-if="dList.length" class="btn btn-outline-danger" @click="groupDestroy">
                    <i class="bi bi-trash2"></i>
                    حذف همه
                </button>
            </div>
            <hr>
            <table class="table table-responsive-lg table-striped table-bordered">
                <thead>
                    <tr>
                        <th> # </th>
                        <th class="marker">
                            <i v-if="dList.length == list.length" class="bi bi-check-square" @click="uncheckAll()"></i>
                            <i v-else class="bi bi-square" @click="checkAll()"></i>
                        </th>
                        <th> <i class="bi bi-file-earmark-spreadsheet-fill text-primary ms-1"></i> نام فایل </th>
                        <th> <i class="bi bi-calendar-fill text-primary ms-1"></i> تاریخ </th>
                        <th> <i class="bi bi-clock-fill text-primary ms-1"></i> ساعت </th>
                        <th colspan="3"> <i class="bi bi-gear-fill text-primary ms-1"></i> عملیات </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item, i in list">
                        <th> {{i+1}} </th>
                        <td class="marker">
                            <i v-if="dList.includes(item.key)" class="bi bi-check-square" @click="uncheck(item.key)"></i>
                            <i v-else class="bi bi-square" @click="check(item.key)"></i>
                        </td>
                        <td> {{item.key}} </td>
                        <td> {{pDate(item.date)}} </td>
                        <td> {{dTime(item.date)}} </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm mx-1" @click="openRoute('jsons.show', [this.folder, item.key])">
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
        props : ['list', 'folder'],
        components: {
            Dashboard
        },
        data : function () {
            return {
                dList : []
            }
        },
        methods : {
            download : function (target) {
                var url = route('jsons.download', [this.folder, target]);
                axios.get(url).then(res => {
                    this.downloadData(JSON.stringify(res.data), target);
                });
            },
            destroy : function (index, target) {
                var url = route('jsons.destroy', [this.folder, target]);
                this.swalAreYouSure(url, this.list, index);
            },
            check : function (key) {
                this.dList.push(key);
            },
            uncheck : function (key) {
                var index = this.dList.indexOf(key);
                this.dList.splice(index, 1);
            },
            uncheckAll : function () {
                this.dList = [];
            },
            checkAll : function () {
                this.dList = [];
                var array = this.list;
                for (var i = 0; i < array.length; i++) {
                    this.dList.push(array[i].key);
                }
            },
            groupDestroy : function () {
                var url = route('jsons.group_destroy', this.folder);
                var data = this.dList;
                axios.post(url, data).then(res => {
                    if (res.data.success) {
                        var array = this.dList;
                        for (var i = 0; i < array.length; i++) {
                            var key = array[i];
                            var list = this.list;
                            for (var i = 0; i < list.length; i++) {
                                if (list[i].key == key) {
                                    list.splice(i, 1);
                                }
                            }
                        }
                        this.swalSuccess('آیتم ها حذف شدند');
                    }else {
                        this.swalError();
                    }
                }).catch(err => {
                    this.swalError();
                });
            }
        }
    })
</script>


<style scoped>


.marker > i {
    cursor: pointer;
}


</style>
