require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Swal from 'sweetalert2';

/*** import necessary css files ***/
import 'sweetalert2/dist/sweetalert2.min.css';

/*** import global components ***/
import { Link } from '@inertiajs/inertia-vue3';


/*** define general methods  ***/


var historyBack = function () {
    history.back();
}

var openRoute = function (routeName, parameters={}) {
    this.$inertia.visit(route(routeName, parameters), { method: 'get' });
}
var openURL = function (url) {
    this.$inertia.visit(url, { method: 'get' });
}

var copyToClipboard = function (text) {
    var input = document.createElement('input');
    input.setAttribute('value', text);
    document.body.appendChild(input);
    input.select();
    var result = document.execCommand('copy');
    document.body.removeChild(input);
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'کپی شد!',
        showConfirmButton: false,
        timer: 1000
    });
}

var swalSuccess = function (message='تغییرات با موفقیت ذخیره شد') {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'عالی!',
        text: message,
        showConfirmButton: false,
        timer: 1500
    });
}
var swalError = function (message='خطایی رخ داد') {
    Swal.fire({
        icon: 'error',
        title: 'خطا...',
        text: message,
    });
}
var swalValidationErrors = function (list) {
    var errorMessages = '';
    for(var key in list) {
        errorMessages += `<p>${list[key]}</p>`;
    }
    Swal.fire({
        icon: 'error',
        title: 'خطا...',
        html: errorMessages,
    });
}
var swalAreYouSure = function (url, array=[], index=-1, method='delete', redirectURL='') {
    Swal.fire({
        title: 'آیا مطمئن هستید؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله',
        cancelButtonText: 'انصراف'
    }).then((result) => {
        if (result.isConfirmed) {
            axios({
                url : url,
                method : method,
            }).then( res => {
                if(res.data.success) {
                    if (array.length) {
                        array.splice(index, 1);
                    }
                    var message = method == 'delete' ? 'آیتم مورد نظر با موفقیت حذف شد.' : 'تغییرات با موفقیت ذخیره شد.';
                    Swal.fire({
                        icon: 'success',
                        title: message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    if (redirectURL) {
                        this.openURL(redirectURL);
                    }
                }
            });
        }
    });
}
var pDate = function (date) {
    return new Date(date).toLocaleDateString('fa-IR');
}
var dTime = function (date) {
    var date = new Date(date);
    var hours = date.getHours();
    var mins = date.getMinutes();
    if (hours < 10) {
        hours = '0'+hours;
    }
    if (mins < 10) {
        mins = '0'+mins;
    }
    return hours + ':' + mins;
}
var downloadData = function (data, filename){
    const url = window.URL.createObjectURL(new Blob([data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
}

createInertiaApp({
    resolve: name => require(`./Pages/${name}.vue`),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
        .use(plugin)
        .mixin({
            methods: {
                swalSuccess, swalError, swalValidationErrors, swalAreYouSure,
                pDate, dTime,
                historyBack, openRoute, openURL,
                copyToClipboard, downloadData
            },
            components : {},
        })
        .mount(el)
    },
});

InertiaProgress.init();
