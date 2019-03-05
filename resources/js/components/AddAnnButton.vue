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
          <!-- <form class="flex-2 mt-auto" @submit.prevent="addAnnouncement">
              <div class="field mb-6">
                  <label class="label text-sm mb-2 block" for="title">Title</label>
    
                  <div class="control">
                      <input
                          type="text"
                          class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                          name="title"
                          placeholder="Announcement title here..."
                          v-model="project.title"
                          required
                          >
                  </div>
    
              </div>
    
              <div class="field mb-6">
                  <label class="label text-sm mb-2 block" for="description">Original email</label>
    
                  <div class="control">
                      <textarea
                          name="description"
                          rows="10"
                          class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                          placeholder="Paste client's email here..."
                          v-model="project.description"
                          required></textarea>
                  </div>
              </div>
    
              <div v-if="feedback">
                  <span class="text-xs text-red" v-text="feedback"></span>
              </div>

              <div class="flex">
                  <div class="ml-auto control flex">
                      <button @click="$modal.hide('addAnnouncementModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-full py-1 px-4 border-2 border-grey">Cancel</button>
                      <button type="submit" class="py-1 px-4 text-lg button rounded-full text-white is-link hover:bg-blue-dark border-2 border-blue">Create</button>
                  </div>
              </div>


          </form> -->
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
