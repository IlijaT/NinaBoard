<template>
  <modal @before-open="beforeOpen" name="calendarModal" :adaptive="true" height="auto" :draggable="true" >
    <div 
      :class="task.completed ? 'border-l-8 border-blue-dark' : ''" 
      class="flex flex-column p-10 h-full justify-center"
      >

      <div class="mb-2">
        <header class="section py-2 mb-2">
          <h1 class="font-bold text-black text-center text-lg">{{ task.title }} </h1>
        </header>

      </div>
      <div class="text-center mb-2">
        <h1 class="text-sm font-normal">
          Date: 
          <span  class="italic text-xs">
          {{ task.startDate }} 
          {{ task.startDate != task.endDate ? '-' : '' }}
          {{ task.startDate != task.endDate ? task.endDate : '' }}
          </span>
        </h1>
        <h1 class="text-sm font-normal mr-2">
          Time:  <span class="italic text-xs">{{ task.startTime }} - {{ task.endTime }}</span>
        </h1>

        <div v-if="task.completed" class="text-center">
          <i class="fas fa-feather-alt text-5xl ml-2 text-blue-dark"></i>
          <div class="text-black text-lg">Completed</div> 
        </div>

        <div v-if="! task.completed" class="form-check">
          <input class="form-check-input" type="checkbox" v-model="task.finished" id="defaultCheck1">
          <label class="form-check-label" for="defaultCheck1">
            Mark as completed
          </label>
        </div>

      </div>

      <div v-if="! task.completed" class="flex mt-4">
       
          <button @click="$modal.hide('calendarModal')" class="flex-1 btn ml-auto mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
          <button 
            :disabled="! task.finished" 
            @click="onSubmit" 
            :class="loading ? 'loader' : ''"
            class="flex-1 btn py-1 px-4 text-lg button rounded-lg text-white hover:bg-blue-dark">Complete</button>
        
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
