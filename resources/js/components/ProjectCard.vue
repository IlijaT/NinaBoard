<template>
    <div class="lg:w-2/5 mt-5 mx-2">
         
        <div style="cursor:pointer" @click="showModal" class="bg-white mt-5 pb-4 card" >
            <h3  class="font-normal mt-4 px-3 py-2 text-lg border-l-4 border-blue-light">
                {{ announcement.title }}
            </h3>
            <div class="text-grey text-xs py-2 px-4 ">{{  announcement.description }}</div>

        </div>
      
            <!-- modal -->
        <modal adaptive name="editProjectModal" height="auto">
            <edit-project-form :project="announcement"></edit-project-form>
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
      events.$on('updatedproject', (data) => this.announcement = data);
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

  }
    
}
</script>
