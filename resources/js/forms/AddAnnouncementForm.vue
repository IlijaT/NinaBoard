<template>
  <form class="p-10" @submit.prevent="onSubmit" @keydown="form.errors.clear()">

    <header class="section py-6 mb-2" style="background: url('/images/splash.svg') 95px 4px no-repeat;">
      <h1 class="text-black text-center text-2xl mb-4">Add New Announcement</h1>
    </header>
    <div class="field mb-2">
      <label class="label text-sm mb-2 block" for="title">Client</label>

      <div class="control">
        <input
          type="text"
          class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
          name="title"
          placeholder="Client title here..."
          v-model="form.title"
          required
          >
          <span v-if="form.errors.has('title')" class="text-red text-xs" v-text="form.errors.get('title')">
          </span>
      </div>

    </div>

    
    <div class="field mb-4">
      <label class="label text-sm mb-2 block" for="description">Original email</label>
      
      <div class="control">
        <wysiwyg name="description" v-model="form.description"></wysiwyg>
        <span v-if="form.errors.has('description')" class="text-red text-xs" v-text="form.errors.get('description')">
        </span>
      </div>
    </div>

    <div class="flex">
      <div class="ml-auto control flex">
          <button @click.prevent="$modal.hide('addAnnouncementModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
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

    data(){
      return {
        form : new Form({ title: '', description: ''}),
        loading: false
      }
    },

    methods: {
      
      onSubmit() {
        this.loading = true;

        this.form.submit('post', '/projects' )
        .then((data) => {
          window.location = "/projects/" + data.project.id;
          flash('Announcement successfully added!', 'green');
        })
        .catch(errors => {
          this.loading = false;
        });
      }
    }
  }
</script>

