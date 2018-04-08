<template>
    <div class="pt-live">
        <div class="pt-live--wrapper">
            <img src="/images/logo.png" class="pt-live--logo"/>
        </div>
        <div class="pt-live--login">
            <input class="pt-input" type="text" placeholder="email" v-model="email"/>
            <input class="pt-input" type="password" placeholder="password" v-model="password"/>

            <button class="pt-live--button" @click="login">Log in</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                email: '',
                password: '',
            }
        },
        methods: {
            login() {
                this.email = '';
                this.password = '';
            }
        }
    }
</script>
<style lang="scss" scoped>
    .pt-live{
        width: 300px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        &--header{
            text-align: center;
            color: #666;
        }

        &--login{
            padding: 10px;
            background-color: #e6e6e6;
            border-radius: 10px;
        }

        &--button{
            margin: 10px 0;
            width: 100%;
            text-align: center;
            background-color: #666;
            color: #fff;
            border: none;
            outline: none;
            height: 35px;
            line-height: 35px;
            border-radius: 2px;
        }

        &--logo{
            width: 300px;
            margin-top: -140px;
        }

        &--wrapper{
            width: 300px;
            height: 60px;
            overflow: hidden;
        }
    }

    .pt-input{
        width: 100%;
        margin: 10px 0;
        height: 35px;
        border-radius: 2px;
        outline: none;
        border: none;
        padding: 10px;
    }
</style>