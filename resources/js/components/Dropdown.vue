<template>
  <div class="dropdown relative">
    <div class="dropdown-trigger" 
    @click.prevent="isOpen = ! isOpen"
    aria-haspopup="true"
    aria-expanded="isOpen"
    >
      <slot name="trigger"></slot>
    </div>

    <transition name="pop-out-quick">
      <div v-show="isOpen" class="absolute mt-2 py-2 rounded shadow z-10 bg-white w-32">
        <slot></slot>
      </div>
    </transition>
  </div>
</template>

<script>
  export default {
      created() {
     
    },

    data() {
      return {
        isOpen: false
      }
    },
    watch: {
      isOpen(isOpen){
        if(isOpen){
          document.addEventListener('click', this.closeIfClickedOutside);
           events.$on('closeconextmenu', () => this.isOpen = false);
        }
      }
    },
    methods: {
      closeIfClickedOutside(event){
        if(! event.target.closest('.dropdown')){
          this.isOpen = false;
        }
      }
    },
    
  }
</script>

<style>

.pop-out-quick-enter-active,
.pop-out-quick-leave-active {
  transition: all 0.4s;
}
.pop-out-quick-enter, 
.pop-out-quick-leave-active
{
  transform: translateY(-7px);
  opacity: 0;
}
</style>
