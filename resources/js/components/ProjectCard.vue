<template>
    <div class="lg:w-2/5 mt-3 mx-2">
         
        <div style="cursor:pointer" @click="showModal" class="bg-white mt-3 pb-4 card" >
            <h3  class="font-normal mt-4 px-3 py-2 text-lg border-l-4 border-blue-light">
                {{ announcement.title }}
            </h3>
            <div class="text-grey text-xs py-2 px-4 ">{{  announcement.description }}</div>

        </div>
      
            <!-- modal -->
        <modal adaptive name="editProjectModal" :height="420">
            <div class="flex flex-column h-full bg-white p-4">
                <h1 class="text-2xl font-normal mb-3 text-center">
                    Change details
                </h1>
                <edit-project-form @updated="updated" :project="announcement"></edit-project-form>
                
            </div>
        </modal>
        
    </div>
</template>

<script>

import EditProjectForm from '../forms/EditProjectForm.vue';

export default {

  components: { EditProjectForm },

  props: ['project'],

  created() {
      this.announcement = this.project;
  },

  data() {
    return {
        announcement: null
    }
  },

  methods: {

    showModal() {
      this.$modal.show('editProjectModal');
    },

    updated(data) {
        this.announcement = data;
    }

  }
    
}
</script>
