<template>
    <div class="alert-flash">
        <div :class="'bg-' + level + '-dark'" class="alert text-white" role="alert" v-show="show">
        {{ body }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message', 'color'],

        data() {
            return {
                body: this.message,
                level: 'green',
                show: false
            }
        },

        created(){

            if(this.message) {
                this.flash(this.message, this.color);
            }

            window.events.$on('flash', data => {
                this.flash(data.message, data.color)
                })

        },

        methods: {

            flash(message, color) {
                this.body = message;
                this.level = color;
                this.show = true;
                this.hide();
            },

            hide(){
                setTimeout(() => this.show = false, 4000);
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