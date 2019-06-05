<template>
  <transition name="fade">
    <div v-if="shouldDisplay">
      <slot></slot>
    </div>
  </transition>
</template>

<script>
  import inViewPort from 'in-viewport';

  export default {
    props: ['whenHidden'],
    data() {
      return {
        shouldDisplay: false
      }
    },
    mounted() {
      window.addEventListener('scroll', () => 
      {
        this.shouldDisplay = ! inViewPort(
          document.querySelector(this.whenHidden)
        );
      }, 
      {passive: true}); 
    },
  }
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .3s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>


