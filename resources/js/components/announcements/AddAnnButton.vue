<template>
<div>
    
    <button class="bg-blue ml-auto btn rounded-lg text-white hover:bg-blue-dark" @click="showModal">Add New</button>


    <!-- modal -->
    <modal :scrollable="true" :adaptive="true" name="addAnnouncementModal" :width="650" height="auto">
        <add-announcement-form></add-announcement-form>
    </modal>
   
</div>

</template>


<script>

import AddAnnouncementForm from '../../forms/AddAnnouncementForm.vue';

export default {
    components: { AddAnnouncementForm },
    methods: {
      showModal() {
        this.$modal.show('addAnnouncementModal');
      },
     
    }
    
}
 

</script>
