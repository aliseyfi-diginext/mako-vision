<template>
    <simple-layout title="Mako-Vision">

        <div class="body">
            <div class="circle"></div>
            <form class="form" @submit.prevent="login">
                <h2 class="form-title"> Mako-Vision Control Panel </h2>
                <p class="form-paragraph"> ورود به حساب کاربری  </p>
                <div class="form-container">
                    <div class="form-group">
                        <input type="text" id="username" v-model="credentials.username" name="username" class="form-input">
                        <label for="username" class="form-label"> <i class="bi bi-person-fill"></i> نام کاربری </label>
                        <span class="form-line"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" v-model="credentials.password" name="password" class="form-input">
                        <label for="password" class="form-label"> <i class="bi bi-lock-fill"></i> رمزعبور </label>
                        <span class="form-line"></span>
                    </div>
                    <button v-if="loading" type="button" class="form-submit" disabled>
                        <span class="spinner light"></span>
                        لطفا صبر کنید
                    </button>
                    <button v-else type="submit" class="form-submit">
                        <i class="bi bi-check-circle"></i>
                        ورود
                    </button>
                </div>
            </form>
            <div class="logo">
                <img src="/img/logo.png" alt="mako-vision">
            </div>
        </div>

    </simple-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import SimpleLayout from '@/Layouts/SimpleLayout.vue'

    export default defineComponent({
        components: {
            SimpleLayout
        },
        data : function () {
            return {
                loading : false,
                credentials : {
                    username : '',
                    password : '',
                }
            }
        },
        methods : {
            login : function () {
                this.loading = true;
                var url = route('login');
                axios.post(url, this.credentials).then(res => {
                    if (res.data.success) {
                        this.openRoute('home');
                        this.swalSuccess('شما با موفقیت وارد حساب کاربری خود شدید.');
                    }else {
                        this.swalError(res.data.message);
                    }
                }).catch(err => {
                    if(err.response.status == 422){
                        var list = err.response.data.errors;
                        this.swalValidationErrors(list);
                    }else {
                        this.swalError();
                    }
                }).then(x => this.loading=false);
            }
        }
    })
</script>


<style scoped>

.body * {
    box-sizing: border-box;
}

.body {
    background-color: #f0f0f0;
    opacity: 0.8;
    background-size: 20px 20px;
    background-position: 0 0,10px 10px;
    display: flex;
    min-height: 100vh;
    direction: ltr;
}

.body::-webkit-scrollbar {
    width: 7px;
}

.body::-webkit-scrollbar-thumb {
    background:#62868A;
    border-radius: 20px;
}
.circle{
    width:50%;
    height:70%;
    position: absolute;
    background:#62868A;
    border-radius:0 0 100%  0;
}

.form{
    direction: rtl;
    background-color: #fff;
    margin: auto;
    width: 90%;
    max-width: 500px;
    padding: 4.5em 3em;
    border-radius: 10px;
    box-shadow: 0 5px 10px -5px rgb(0 0 0 / 30%);
    text-align: center;
    background: rgba(255, 255, 255, 0.877);
    border-radius: 16px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(12.2px);
    -webkit-backdrop-filter: blur(12.2px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition:1s;
}

.form-title{
    font-size: 2rem;
    margin-bottom: .5em;
}
.form-paragraph{
    font-size: 18px;
}
.form-container{
    margin-top: 3em;
    display: grid;
    gap: 2.5em;
}
.form-group{
    position: relative;
    color: ##969089;
}
.form-input{
    width: 100%;
    background: none;
    --color: #969089;
    font-size: 1rem;
    padding: .6em .3em;
    border: none;
    outline: none;
    border-bottom: 1px solid var(--color);
    direction: ltr;
}

.form-input:focus + .form-label {
    transform: translateY(-12px) scale(.8);
    transform-origin:right top;
    color: #62868A;
    font-size: 20px;
}
.form-label{
    color: #656060;
    cursor: pointer;
    position: absolute;
    top: -10px;
    right: 5px;
    transform: translateY(10px);
    transition: transform .5s, color .3s;
    font-size: 16px;
}
.form-submit{
    background: #62868A;
    color:#fff;
    font-weight: 300;
    font-size: 1.1rem;
    padding: .8em 0;
    border: none;
    border-radius: .5em;
    cursor: pointer;
    width: 80%;
    margin: 0 auto;
    transition: .25s;
}
.form-submit:not(:disabled):hover {
    transform: scale(1.1);
}
.form-line{
    position: absolute;
    bottom:0;
    left: 0;
    width: 100%;
    height: 1px;
    background-color: #62868A;
    transform: scale(0);
    transform: left bottom;
    transition: transform .4s;
}

.form-input:focus ~ .form-line,
.form-input:not(:placeholder-shown) ~ .form-line{
    transform: scale(1);
}
@media (max-width:425px){
    .form-title{
        font-size: 1.8rem;
    }
}

.logo {
    position: fixed;
    top: 10px;
    display:flex;
    right: 20%;
}

.logo > img {
    max-height: 100px;
}

@media only screen and (max-width: 600px) {
    .logo {
        display: none;
    }
}
</style>
