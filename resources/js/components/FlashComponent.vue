<template>
    <div class="alert-flash">
        <div class="alert  bg-green-dark text-white" role="alert" v-show="show">
        {{ body }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                show: false
            }
        },

        created(){
            if(this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => {
                this.flash(message);
            })


        },

        methods: {
            flash(message) {
                this.body = message;
                this.show = true;

                this.hide();

            },
             hide(){
                 setTimeout(() => this.show = false, 3000);
             },
        }
    }
</script>

<style>
    .alert-flash{
        position: fixed;
        right: 25px;
        bottom: 25px
    }
</style>

