<template>
                   
  <div>
    <div v-for="task in tasks" :key="task.id" class="bg-white p-3 mb-2 card w-full">
      <task-component :task="task"></task-component>

    </div>
  </div>
                   
<!--     
      @if ($errors->has('body'))
          <span 
              style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
              role="alert"
          ><strong>{{ $errors->first('body') }}</strong>
      @endif --}} -->

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
        tasks: []
      }
    },

    methods: {
      
     
    }
    
}
 

</script>
