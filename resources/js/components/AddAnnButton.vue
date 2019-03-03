<template>
<div>
    
    <button class=" bg-blue ml-auto text-normal btn rounded-full text-white hover:bg-blue-dark" @click="showModal">Add New</button>


<!-- modal -->
<modal adaptive name="addAnnouncementModal" :height="500">
        <div class="flex flex-column h-full bg-white p-6">
    
          <h1 class="flex-1 text-2xl font-normal mb-10 text-center">
              Create an Announcement
          </h1>
    
          <form class="flex-2 mt-auto" @submit.prevent="addAnnouncement">
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
    
                    <!-- @if ($errors->has('title'))
                      <span 
                          style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
                          role="alert"
                      ><strong>{{ $errors->first('title') }}</strong>
                  @endif   -->
              </div>
    
              <div class="field mb-6">
                  <label class="label text-sm mb-2 block" for="description">Description</label>
    
                  <div class="control">
                      <textarea
                          name="description"
                          rows="10"
                          class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                          placeholder="Announcement description here..."
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


          </form>
      </div>
    </modal>
   
</div>

</template>


<script>

export default {

    data(){
      return {
        project: { title: '', description: ''},
        feedback: ''
      }
    },

    methods: {
      showModal() {
        this.$modal.show('addAnnouncementModal');
      },
            addAnnouncement() {

        axios.post('/projects', {'title': this.project.title, 'description': this.project.description})
        .then((data) => {
            flash('Announcement successfully added!', 'green');
            window.location = "/projects/" + data.data.project.id;
          } )
        .catch(error => this.feedback = error.response.data);
      }
    }
    
}
 

</script>
