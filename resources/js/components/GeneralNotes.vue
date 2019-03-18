<template>
  <div>

    <div style="cursor:pointer" @click="addNotesModal" class="bg-white mt-5 pb-4 card" >
    
    <div class="text-grey text-xs py-2 px-4 ">{{  projectInComponent.notes }}</div>


    </div>
  
    <!-- modal -->
    <modal adaptive name="addNotesModal" :height="300">
      <general-note-form @updatedNotes="updatedNotes" :project="projectInComponent"></general-note-form>
    </modal>
  </div>



  
</template>

<script>

import GeneralNoteForm from '../forms/GeneralNoteForm.vue';

export default {

  components: { GeneralNoteForm },

  props: ['project'],

  created() {
    this.projectInComponent = this.project ;
  },

  data() {

    return {
      projectInComponent: this.project,
      
    }
  },



  methods: {

    addNotesModal() {
      this.$modal.show('addNotesModal');
  
    },

    updatedNotes(data) {
      this.projectInComponent = data;
      flash('The notes has been updated!', 'green');
    }
  

  }
  
}
</script>
