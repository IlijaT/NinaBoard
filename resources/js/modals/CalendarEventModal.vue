<template>
  <modal adaptive name="calendarModal" :height="270" @before-open="beforeOpen">
    <div 
      :class="task.completed ? 'border-l-8 border-green' : 'border-l-8 border-orange'" 
      class="flex flex-column p-2  h-full justify-center"
      >

      <div class="mb-2">
        <h1 class="text-2xl font-bold m-3 text-center">
          {{ task.title }}  
        </h1>

      </div>
      <div class="text-center">
        <h1 class="text-sm font-normal">
          {{ task.startDate }} 
          {{ task.startDate != task.endDate ? '-' : '' }}
          {{ task.startDate != task.endDate ? task.endDate : '' }}
        </h1>
        <h1 class="text-sm font-normal mr-2">
           {{ task.startTime }} - {{ task.endTime }}
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

      </div>

      <div class="flex mt-auto">
        <div class="ml-auto control flex">
          <button @click="$modal.hide('calendarModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-full py-1 px-4 border-2 border-grey">Cancel</button>
          <button 
            v-if="! task.completed" 
            :disabled="! task.finished" 
            @click="onSubmit" 
            :class="loading ? 'loader' : ''"
            class="btn py-1 px-4 text-lg button rounded-full text-white hover:bg-blue-dark hover:border-blue-dark  border-2 border-blue">Save</button>
        </div> 
      </div> 

    </div>
  </modal>


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
        },
        loading: false
        
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
        this.loading = true;
        axios.post('/tasks/' + this.task.id, {'completed': this.task.finished})
        .then((data) => {
            this.$modal.hide('calendarModal');
            this.task.finished = false;
            this.loading = false;
            this.$emit('completed', data.data);
          })
        .catch(error => {
          this.loading = false;
          flash('Ooops! Something went wrong!', 'red');
          $modal.hide('calendarModal')
        });
      }
     
    }
    
}
 

</script>
