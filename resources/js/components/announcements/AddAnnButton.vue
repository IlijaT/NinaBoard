<template>
    <div>
        <button :class="style" @click="showModal">{{ text }}</button>
        <!-- modal -->
        <modal :scrollable="true" :adaptive="true" name="addAnnouncementModal" :width="650" height="auto">
            <add-announcement-form></add-announcement-form>
        </modal>
    </div>
</template>

<script>

import AddAnnouncementForm from '../../forms/AddAnnouncementForm.vue';

export default {
    props: ['propStyle', 'text'],
    components: { AddAnnouncementForm },

    methods: {
      showModal() {
        this.$modal.show('addAnnouncementModal');
      },
    },

    computed: {
      style () {
        return this.propStyle;
      }
    }
    
}
 

</script>

<style scoped>
    button:focus {outline:0 !important;}
</style>

