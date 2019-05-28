<template>
  <div class="bg-white py-3 pr-3 pl-0 mb-2 card w-full">

    <div class="flex justify-between items-center">

      <div
        :title="computedTitle" 
        :style="{cursor: computedCursor }"
        @click="showEditTaskModal" 
        :class="{
          'border-blue': taskInComponent.completed,
          'border-orange-dark': !taskInComponent.completed && !taskInComponent.cancelled,
          'border-grey-dark': !taskInComponent.completed && taskInComponent.cancelled,
          'text-grey-dark': taskInComponent.completed }" 
        class="border-l-4  px-3">
        {{ taskInComponent.title }} 
        <span 
        class="text-xs mx-1 text-grey italic"
        v-if="taskInComponent.cancelled">
        - {{ taskInComponent.cancelled }}
        </span>
      </div>

      <div class="px-1 flex text-xs text-grey items-center">{{ diffforhumans(taskInComponent.start) }} 

        <div 
          v-if="!taskInComponent.completed && !taskInComponent.cancelled"
          title="Complete the task" 
          style="cursor:pointer"
          @click="emitEvent">
          <i class="far fa-square text-grey-dark ml-2 hover:text-blue-dark"></i>
        </div>

        <div 
          class="ml-2"
          v-if="!taskInComponent.completed && !taskInComponent.cancelled"
          title="More options" 
          style="cursor:pointer"
          >
         <dropdown>
           <template v-slot:trigger>
             <button><i class="fas fa-chevron-down text-grey-dark hover:text-blue-dark"></i></button>
           </template>
           <div
            @click.prevent="showEditTaskModal"
            title="Edit task" 
            class="px-3 hover:bg-blue-light hover:text-white text-grey-darkest leading-loose text-sm block">
            Edit Task
           </div>
           <div
            @click.prevent="copyTask"
            title="Copy task" 
            class="px-3 hover:bg-blue-light hover:text-white text-grey-darkest leading-loose text-sm block">
            Copy Task
          </div>
           <div
            @click.prevent="deleteTask"
            title="Delete task" 
            class="px-3 hover:bg-blue-light hover:text-white text-grey-darkest leading-loose text-sm block">
            Delete Task
          </div>
         </dropdown>
        </div>

        <div v-if="taskInComponent.completed">
          <i class="fas fa-feather-alt text-xl ml-2 text-blue"></i>
        </div>

        <div v-if="!taskInComponent.completed && taskInComponent.cancelled">
          <i class="fas fa-bell-slash text-lg ml-2 text-grey-dark"></i>
        </div>

      </div>
      
    </div>

  </div>
</template>


<script>

import moment from 'moment';

export default {
    props: ['task'],

    created() {
      this.taskInComponent = this.task;
      events.$on('editedtask', (data) => this.onEditedTask(data));
      events.$on('completedtask', (data) => this.onConpletedTask(data));
    },

    data() {
      return {
        taskInComponent: '',
      }
    },

    methods: {
      diffforhumans(dateCreated) {
        return moment(dateCreated).format('DD MMM YYYY')
      },
      emitEvent() {
        this.$emit('showCompleteTaskModal', this.taskInComponent);
      },
      showEditTaskModal() {
        if(this.taskInComponent.completed){
          return;
        }
        events.$emit('closeconextmenu');
        this.$emit('showEditTaskModal', this.taskInComponent);
      },
      copyTask() {
        events.$emit('closeconextmenu');
        axios.post('/projects/' + this.taskInComponent.project_id + '/tasks', 
          {
          'title': this.taskInComponent.title, 
          'start': this.taskInComponent.start,
          'end': this.taskInComponent.end,
          })
          .then((data) => {
              events.$emit('addedtask', data.data);
             
              flash('New task has added successfully!', 'green');
            })
          .catch(error => flash('Oooops! Something went wrong!', 'red'));
      },
      deleteTask() {
        events.$emit('closeconextmenu');
        console.log('deletedtask');
        // axios.delete('/projects/' + this.taskInComponent.project_id + '/tasks', 
        //   )
        //   .then((data) => {
        //       events.$emit('deletedtask', data.data);
             
        //       flash('A task has been deleted!', 'red');
        //     })
        //   .catch(error => flash('Oooops! Something went wrong!', 'red'));
      },
      onEditedTask(data) {
        if( this.taskInComponent.id == data.id) {
          this.taskInComponent = data;
          flash('The task has been updated successfully!', 'green');
        }
        
      },
      onConpletedTask(data){
        if( this.taskInComponent.id == data.id) {
          this.taskInComponent = data;
        }
      }

    },

    computed: {
      computedCursor() {
        return this.taskInComponent.completed ? '' : 'pointer';
      },
      computedTitle() {
        return this.taskInComponent.completed ? '' : 'Edit task\'s details'; 
      }
    }
    
}
 
</script>
