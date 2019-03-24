<template>
  <div class="bg-white py-3 pr-3 pl-0 mb-2 card w-full">

    <div class="flex justify-between items-center">

      <div
        :style="{cursor: computedCursor }"
        @click="showEditTaskModal" 
        :class="{'border-blue': taskInComponent.completed, 'border-red-dark': !taskInComponent.completed }" 
        class="border-l-4  pl-3">
        {{ taskInComponent.title }}
      </div>

      <div  class="flex text-xs text-grey">{{ diffforhumans(taskInComponent.start) }} 

        <div 
          v-if="!taskInComponent.completed" 
          style="cursor:pointer"
          @click="emitEvent">
          <i class="far fa-square text-xl ml-2"></i>
        </div>

        <div v-else>
          <i class="fas fa-feather-alt text-xl ml-2 text-blue"></i>
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
        this.$emit('showEditTaskModal', this.taskInComponent);
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
      }
    }
    
}
 
</script>
