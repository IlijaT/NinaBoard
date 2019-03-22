<template>
                   
  <div>
    <div v-for="task in tasks" :key="task.id" >
      <task-component @showCompleteTaskModal="showCompleteTaskModal" :task="task"></task-component>
    </div>

    <!-- modal -->
    <modal name="completeTask" height="auto">
      <div class="p-10">
        <div class="text-grey text-2xl text-center mb-4">
          Complete the task?
        </div>

        <div class="ml-auto flex">
            <button @click.prevent="$modal.hide('completeTask')" class="btn ml-auto mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
            <button 
              @click="onComplete" 
              :class="loading ? 'loader' : ''"
              class="btn py-1 px-4 text-lg button rounded-lg text-white hover:bg-blue-dark"  
              >Complete
            </button>
        </div>
      </div>
    </modal>
  </div>
                   
</template>


<script>

import TaskComponent from './TaskComponent.vue';

export default {
    props: ['projecttasks'],

    components: { TaskComponent },

    created() {
      this.tasks = this.projecttasks;
    },

    data() {
      return {
        tasks: [],
        taskForCompleting: null,
        loading: false
      }
    },

    methods: {
      showCompleteTaskModal(data) {
        this.taskForCompleting = data;
        this.$modal.show('completeTask')
      },
      onComplete() {
        this.loading = true;
        axios.post(`/tasks/${this.taskForCompleting.id}`, {'completed': true})
        .then((data) => {
            this.$modal.hide('completeTask');
            this.taskForCompleting = null;
            this.tasks = this.tasks.map(task => { 
              if(task.id == data.data.id) {
                task.completed = true;
              }
              return task;
            });
            flash('You completed the task! Congrats!!!', 'green');
            events.$emit('completedtask', data.data.activities[0]);
            this.loading = false;
          })
        .catch(error => {
          this.loading = false;
          flash('Ooops! Something went wrong!', 'red');
          $modal.hide('completeTask')
        });
      }
    },
    
}
 

</script>
