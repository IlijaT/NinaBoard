<template>
  <div>

    <div style="cursor:pointer" @click="addNotesModal" class="bg-white card" >
    
      <div class="text-grey text-xs p-4" v-html="projectInComponent.notes"></div>

    </div>
  
    <!-- modal -->
    <modal adaptive name="addNotesModal" :width="650" height="auto">
      <general-note-form @updatedNotes="updatedNotes" :project="projectInComponent"></general-note-form>
    </modal>
  </div>
  
</template>

<script>

import GeneralNoteForm from '../../forms/GeneralNoteForm.vue';

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
      flash('General notes has been updated!', 'green');
      events.$emit('updatednote', data.activities);
    }

  }
  
}
</script>
