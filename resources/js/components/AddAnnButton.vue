<template>
<div>
    
    <button class=" bg-blue ml-auto text-normal btn rounded-full text-white hover:bg-blue-dark" @click="showModal">Add New</button>


    <!-- modal -->
    <modal adaptive name="addAnnouncementModal" :height="550">
        <div class="flex flex-column h-full bg-white p-6">
        
            <h1 class="flex-1 text-2xl font-normal mb-10 text-center">
                Create an Announcement
            </h1>

            <add-announcement-form></add-announcement-form>
            
        </div>
    </modal>
   
</div>

</template>


<script>

import AddAnnouncementForm from '../forms/AddAnnouncementForm.vue';

export default {
    components: { AddAnnouncementForm },
    methods: {
      showModal() {
        this.$modal.show('addAnnouncementModal');
      },
     
    }
    
}
 

</script>
