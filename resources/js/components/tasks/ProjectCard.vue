<template>
    <div class="lg:w-2/5 mt-5 mx-2">
         
        <div class="bg-white mt-5 pb-3 card" >
            <h3  class="font-normal mt-4 px-3 py-2 text-lg border-l-4 border-blue-light">
                {{ announcement.title }}
            </h3>

            <div class="text-grey text-xs py-2 px-4" v-html="announcement.description"></div>
            
            <div class="flex py-2 px-4">
                <div class="ml-auto py-1 px-1"> 
                    <button  @click="showModal">
                        <i class="fas fa-edit text-grey-dark text-normal"></i>
                    </button>
                </div>
                <div 
                    v-if="logged.roles[0].name == 'manager'"
                    class="py-1 px-1"
                    >
                    <button @click="showDeleteModal">
                        <i class="fas fa-folder-open text-grey-dark text-normal"></i>
                    </button>
                </div>

            </div>
        </div>
      
        <!-- edit modal -->
        <modal adaptive name="editProjectModal" :width="650" height="auto">
            <edit-project-form :project="announcement"></edit-project-form>
        </modal>

        <!-- delete modal -->
        <modal adaptive name="deleteProjectModal" height="auto">
            <div class="p-10">

                <header class="section py-6 mt-4 mb-6" style="background: url('/images/splash.svg') 45px 4px no-repeat;">
                <h1 class="text-grey-darker font-bold text-center text-2xl mb-4">Archive the announcement?</h1>
                </header>

                <div class="flex mt-auto">
                <button 
                    @click.prevent="$modal.hide('deleteProjectModal')" 
                    class="flex-1 btn ml-auto mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey"
                    >
                    Cancel
                </button>
                <button
                    @click="onDelete"
                    :class="loading ? 'loader' : ''"
                    class="flex-1 btn py-1 px-4 text-lg button rounded-lg text-white hover:bg-blue-dark"
                    >Yes
                </button>
            </div>
        </div>
        </modal>
        
    </div>
</template>

<script>

import EditProjectForm from '../../forms/EditProjectForm.vue';

export default {

  components: { EditProjectForm },

  props: ['project', 'logged'],

  created() {
      this.announcement = this.project;
      events.$on('updatedproject', (data) => this.announcement = data);
  },

  data() {
    return {
        announcement: null,
        loading: false
    }
  },

  methods: {

    showModal() {
      this.$modal.show('editProjectModal');
    },
    showDeleteModal() {
      this.$modal.show('deleteProjectModal');
    },
    onDelete() {
        this.loading = true;
        axios.delete(`/projects/${this.announcement.id}`)
        .then((data) => {
            this.$modal.hide('deleteProjectModal');
            window.location = "/projects/";
            flash('The announcement has been archived!', 'green');
            this.loading = false;
          })
        .catch(error => {
            this.loading = false;
            flash('Ooops! Something went wrong!', 'red');
            this.$modal.hide('deleteProjectModal')
        });
    }

  }
    
}
</script>
