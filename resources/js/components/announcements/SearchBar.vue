<template>
    <div class="flex content-center mr-1">
        <div>
            <transition name="slide-fade">
                <input
                    autofocus
                    ref="search"
                    class="lg:w-64 p-2 px-3 text-grey text-xs rounded-lg border border-blue focus:outline-none"
                    v-show="state == 'open'"
                    placeholder="Search here..."
                    v-model="search" 
                    type="text" 
                    />
            </transition>
        </div>
        <div>
            <i @click="toggleState()"
                style="cursor:pointer"
                class="fa fa-search p-2 text-xl text-grey hover:text-grey-darker">
            </i>
        </div>
    </div>
</template>

<script>
export default {
 
    data(){
        return {
            state: 'close',
            search: '',
        }
    },
    watch:{
        search() {
            events.$emit('search', this.search);
        }
    },

    methods: {
        toggleState() {
            if(this.state == 'close') {
                this.state = 'open';

                this.$nextTick(function () {
                    this.$refs.search.focus()
                })
              
            } else {
                this.state = 'close';
                this.search = '';
            }
        }
    }

 
}
</script>

<style scoped>

    .slide-fade-enter-active {
    transition: all .2s ease;
    }
    .slide-fade-leave-active {
    transition: all .2s ease;
    }
    .slide-fade-enter, .slide-fade-leave-to
    {
    transform: translateX(5px);
    opacity: 0;
    }
</style>


