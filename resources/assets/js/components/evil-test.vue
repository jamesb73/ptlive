<template>
    <div class="test">
        <button @click="login">Get Data</button>
        <div> {{ data }} </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: '',
            }
        },
        methods: {
            // 'https://develop.notactivelylooking.com/admin/delete-modal/6863'

            login() {
                $.ajax({
                    type: "GET",
                    cache: false,
                    xhrFields: {
                        withCredentials: true
                    },
                    url: 'https://web.nal.test/messages/all-conversations-panel/1964',
                    success: data => {
                        // do something with data
                    },
                });
            }
        }
    }
</script>
<style lang="scss" scoped>
    .test{
        padding: 20px;
    }
</style>