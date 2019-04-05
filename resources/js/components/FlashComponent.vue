<template>
    <div class="alert-flash">
        <transition name="fade">
            <div v-if="show" :class="'bg-' + level + '-dark'" class="alert text-white" role="alert">{{ body }}</div>
            
            <!-- <div :class="'bg-' + level + '-dark'" class="alert text-white" role="alert" v-show="show">
            {{ body }}
            </div> -->
        </transition>
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

    .fade-enter-active, .fade-leave-active {
    transition: opacity .9s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
    }
    
</style>