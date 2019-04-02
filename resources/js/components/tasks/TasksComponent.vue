<template>

  <div>
    <div v-for="task in tasks" :key="task.id" >
      <task-component
        @showEditTaskModal="showEditTaskModal"
        @showCompleteTaskModal="showCompleteTaskModal"
        :task="task">
      </task-component>
    </div>

    <!-- modal -->
    <modal name="completeTask" height="auto">
      <div class="p-10">

        <header class="section py-6 mt-4 mb-6" style="background: url('/images/splash.svg') 100px 4px no-repeat;">
          <h1 class="text-grey-darker font-bold text-center text-2xl mb-4">Complete the task?</h1>
        </header>

        <div class="flex mt-auto">
          <button @click.prevent="$modal.hide('completeTask')" class="flex-1 btn ml-auto mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
          <button
            @click="onComplete"
            :class="loading ? 'loader' : ''"
            class="flex-1 btn py-1 px-4 text-lg button rounded-lg text-white hover:bg-blue-dark"
            >Complete
          </button>
        </div>
      </div>
    </modal>
    <edit-task></edit-task>
  </div>

</template>


<script>

import TaskComponent from './TaskComponent.vue';
import EditTask from './EditTask.vue';

export default {
    props: ['projecttasks'],

    components: { TaskComponent, EditTask },

    created() {
      this.tasks = this.projecttasks;
      events.$on('addedtask', (data) => this.tasks.push(data));

    },

    data() {
      return {
        tasks: [],
        taskForCompleting: null,
        taskForEditing: null,
        loading: false
      }
    },

    methods: {
      showCompleteTaskModal(data) {
        this.taskForCompleting = data;
        this.$modal.show('completeTask')
      },
      showEditTaskModal(data){
        this.taskForEditing = data;
        this.$modal.show('editTaskModal', {'taskForEditing': data});
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
            events.$emit('completedtask', data.data);
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
