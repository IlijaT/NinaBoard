<template>

  <form class="p-10" @submit.prevent="onSubmit" @keydown="form.errors.clear()">
    <div class="field mb-2">
      <label class="label text-sm mb-1 block" for="title">Client</label>

      <div class="control">
          <input
            type="text"
            class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
            name="title"
            v-model="form.title"
            >
            <span v-if="form.errors.has('title')" class="text-red text-xs" v-text="form.errors.get('title')">
            </span>
      </div>

    </div>

    <div class="field mb-4">
      <label class="label text-sm mb-1 block" for="title">Email text</label>

      <div class="control">
          <textarea 
            class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
            name="description"
            rows="8"
            v-model="form.description">
            </textarea>
          <span v-if="form.errors.has('description')" class="text-red text-xs" v-text="form.errors.get('description')">
          </span>
      </div>

    </div>

    <div class="flex">
      <div class="ml-auto control flex">
        <button @click.prevent="$modal.hide('editProjectModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
        <button 
          type="submit" 
          :class="loading ? 'loader' : ''"
          class="btn py-1 px-4 text-lg button rounded-lg text-white hover:bg-blue-dark" :disabled="form.errors.any()"
          >Save</button>
      </div>
    </div>

  </form>
    
</template>

<script>
  export default {
   props: ['project'],
    data(){
      return {
        form : new Form({ title: this.project.title, description: this.project.description, }),
        loading: false
      }
    },

    methods: {
      
      onSubmit() {
       
        this.loading = true;

        this.form.submit('patch', '/projects/' + this.project.id )
          .then((data) => {
            this.loading = false;
            events.$emit('updatedproject', data);
            this.$modal.hide('editProjectModal');
            flash('The announcement has been updated!', 'green');
          })
          .catch(errors => {
            flash('Ooooops! Something went wrong', 'red');
            this.loading = false;
          });
      }
    }
  }
</script>