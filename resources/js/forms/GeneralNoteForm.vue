<template>

  <form class="p-10" @submit.prevent="onSubmit" @keydown="form.errors.clear()">

    <div class="field mb-4">
      <div class="control">
          <textarea
              name="notes"
              rows="10"
              class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full"
              v-model="form.notes"
              required
              ></textarea>
          <span v-if="form.errors.has('notes')" class="text-red text-xs" v-text="form.errors.get('notes')">
          </span>
      </div>
    </div>

    <div class="flex">
      <div class="ml-auto control flex">
          <button @click.prevent="$modal.hide('addNotesModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
          <button 
            type="submit" 
            :class="loading ? 'loader' : ''"
            class="btn py-1 px-4 text-lg button rounded-lg text-white hover:bg-blue-dark" :disabled="form.errors.any()"
            >Create</button>
      </div>
    </div>
    
  </form>
  
</template>

<script>
  export default {
   props: ['project'],

    data(){
      return {
        form : new Form({ notes: this.project.notes}),
        loading: false
      }
    },

    methods: {
      
      onSubmit() {
        this.loading = true;

        this.form.submit('patch', '/projects/' + this.project.id )
        .then((data) => {
          this.loading = false;
          this.$modal.hide('addNotesModal');
          this.$emit('updatedNotes', data);
        })
        .catch(errors => {
          flash('Ooooops! Something went wrong', 'red');
          this.loading = false;
        });
      }
    }
  }
</script>
