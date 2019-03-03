<template>
  <div>
    
    <div class="flex mt-4">
      <button class="rounded-full px-2 h-8 w-8 text-grey mr-2 bg-white text-xl border-2 border-grey" @click="showModal">+</button>
      <p class="text-grey text-lg ml-1 cursor-pointer"  @click="showModal">Add New Task</p>
    </div>
    
    <!-- modal -->
    <modal adaptive name="addTaskModal" :width="650" :height="500">
      <div class="flex flex-column bg-white p-6">
  
        <h1 class="flex-1 text-2xl font-normal mb-2 text-center">
            New Task
        </h1>
  
        <form class="flex-2" @submit.prevent="addTask">
          <div class="field mb-6">

            <label class="label text-sm mb-2 block" for="title">Task</label>
            <div class="control mb-1">
              <input
                  type="text"
                  class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                  name="title"
                  placeholder="Task title..."
                  v-model="task.title"
                  required
                  >
            </div>

            <div class="control mb-1">
              <label class="label text-sm mb-2 block" for="title">Dates</label>
              <div class="flex">
                <div class="flex-1 mr-1">
                  <datepicker
                  :mondayFirst="true"
                  :bootstrap-styling="true" 
                  placeholder="Start Date"
                  @selected="selectedStartDate"
                  v-model="startDate">
                  </datepicker>
                </div>
                <div class="flex-1 ml-1">
                  <datepicker
                    :mondayFirst="true"
                    :bootstrap-styling="true"
                    placeholder="End Date"
                    :disabled="! startDate"
                    @selected="selectedEndDate"
                    :disabledDates="disabledDays"
                    v-model="endDate">
                  </datepicker>
                </div>
              </div>
            </div>

            <div class=" mb-1">
              <label class="label text-sm mb-2 block" for="title">Interval</label>
              <div  >
                <div class="mr-1">
                  <vue-timepicker :minute-interval="5" v-model="startTimeValue"></vue-timepicker>
                  <vue-timepicker :minute-interval="5" v-model="endTimeValue"></vue-timepicker>
                </div>
              </div>
            </div>
                  
          </div>
      
          <div v-if="feedback">
              <span class="text-xs text-red" v-text="feedback"></span>
          </div>

          <div class="flex">
              <div class="ml-auto control flex">
                  <button @click="$modal.hide('addTaskModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-full py-1 px-4 border-2 border-grey">Cancel</button>
                  <button type="submit" class="py-1 px-4 text-lg button rounded-full text-white hover:bg-blue-dark hover:border-blue-dark  border-2 border-blue">Save</button>
              </div>
          </div>

        </form>
      </div>
    </modal>
    
  </div>

</template>


<script>

import Datepicker from 'vuejs-datepicker';
import VueTimepicker from 'vue2-timepicker';
import moment from 'moment';

export default {

    components: { Datepicker, VueTimepicker },

    props: ['project'],
    data(){
      return {
        task: { title: '', start: '', end: ''},
        startDate: '',
        formatedStartDate: '',
        formatedEndDate: '',
        endDate: '',
        disabledDays: {
          to: new Date()
        },
        startTimeValue: {
          HH: "00",
          mm: "00",
          ss: "00"
        },
        endTimeValue: {
          HH: "00",
          mm: "00",
          ss: "00"
        },

        feedback: ''
      }
    },

    methods: {
      showModal() {
        this.$modal.show('addTaskModal');
      },

      addTask() {
        console.log("start date");
        console.log(this.formatedStartDate);
        console.log("end date");
        console.log(this.formatedEndDate);


        console.log("start time");
        console.log(this.startTimeValue);
        console.log("end time");
        console.log(this.endTimeValue);


        
        // axios.pos;t('/projects' + this.project.id + '/tasks', {'title': this.task.title, 'start': this.task.start, 'end': this.task.end})
        // .then((data) => {
        //     flash('Task successfully added!', 'green');
        //     location.reload();
        //   } )
        // .catch(error => this.feedback = error.response.data);
      },

      selectedStartDate(date) {
        this.formatedStartDate = moment(date).format('YYYY-MM-DD');
        this.disabledDays.to = new Date(this.formatedStartDate);
        this.selectedEndDate(date);
        this.endDate = this.formatedStartDate;

      },

      selectedEndDate(date) {
        this.formatedEndDate = moment(date).format('YYYY-MM-DD')
      },

      
    }
    
}
 

</script>
