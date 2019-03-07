<template>
  <div>
    <modal adaptive name="calendarModal" :height="250" @before-open="beforeOpen">
      <div class="flex flex-column p-2 h-full">
  
        <h1 class="text-xl font-normal mb-4 text-center">
            {{ task.title }}  
        </h1>
        
        <h1 class="text-sm font-normal mb-4">
            Start: {{ task.startDate }} - {{ task.startTime }}
        </h1>

         <h1 class="text-sm font-normal mb-4">
            End: {{ task.endDate }} - {{ task.endTime }}
        </h1>

        <div v-if="task.completed" class="text-center text-4xl ">
          Completed <i  class="fas fa-check text-4xl text-blue"></i> 
        </div>

        <div v-if="! task.completed" class="form-check">
          <input class="form-check-input" type="checkbox" v-model="task.finished" id="defaultCheck1">
          <label class="form-check-label" for="defaultCheck1">
            Mark as completed
          </label>
        </div>

        <div class="flex mt-auto">
          <div class="ml-auto control flex">
            <button @click="$modal.hide('calendarModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-full py-1 px-4 border-2 border-grey">Cancel</button>
            <button v-if="! task.completed" :disabled="! task.finished" @click="onSubmit" class="btn py-1 px-4 text-lg button rounded-full text-white hover:bg-blue-dark hover:border-blue-dark  border-2 border-blue">Save</button>
          </div> 
        </div> 
       
      </div>
       
    </modal>
  </div>

</template>

<script>

export default {

    data() {
      return {
        task: {
          id: '',
          title: '',
          color: '',
          startDate: '',
          startTime: '',
          endDate: '',
          endTime: '',
          completed: false,
          finished: false,
        }
        
      }
    },

    methods: {
      beforeOpen (event) {
        this.task.id = event.params.task.id;
        this.task.title = event.params.task.title;
        this.task.color = event.params.task.color;
        this.task.startDate = event.params.task.start.format("Do MMM YYYY");
        this.task.startTime = event.params.task.start.format("HH:mm:ss");
        this.task.endDate = event.params.task.end.format("Do MMM YYYY");
        this.task.endTime = event.params.task.end.format("HH:mm:ss");
        this.task.completed = event.params.task.completed;
      },

      onSubmit() {
        axios.post('/tasks/' + this.task.id, {'completed': this.task.finished})
        .then((data) => {
            this.$modal.hide('calendarModal')
            this.$emit('completed', data.data);
          })
        .catch(error => {
          console.log(error)
          $modal.hide('calendarModal')
        });
      }
     
    }
    
}
 

</script>
