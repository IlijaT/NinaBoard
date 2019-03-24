<template>
  <div>
    
    <div class="flex">
      <button @click="showModal" class="py-1 px-3 button btn rounded-lg text-white hover:bg-blue-dark">Add Task</button>
    </div>
    
    <!-- modal -->
    <modal adaptive name="addTaskModal"  :height="550" :width="650">
        <form class="p-10 flex flex-column h-full" @submit.prevent="addTask">

            <label class="label text-sm mb-2 block" for="title">Task</label>
            <div class="control mb-2">
              <input
                  type="text"
                  class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                  name="title"
                  placeholder="Task title..."
                  v-model="task.title"
                  required
                  >
            </div>

            <div class="control mb-2">
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

            <div class="mb-1">
              <label class="label text-sm mb-2 block" for="title">Interval</label>
              
              <div class="mr-1">
                <vue-timepicker :minute-interval="5" v-model="startTimeValue"></vue-timepicker>
                <vue-timepicker :minute-interval="5" v-model="endTimeValue"></vue-timepicker>
              </div>
               
            </div>

            <div class="flex mt-auto">
              <div class="ml-auto control flex">
                <button @click.prevent="$modal.hide('addTaskModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
                <button 
                  type="submit"
                  :class="loading ? 'loader' : ''"
                  class="btn py-1 px-4 text-lg button rounded-lg text-white hover:bg-blue-dark hover:border-blue-dark  border-1 border-blue"
                  >Save</button>
              </div> 
            </div> 

        </form>
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
        loading: false,
        task: { title: '', start: '', end: ''},
        startDate: '',
        formatedStartDate: '',
        formatedEndDate: '',
        endDate: '',
        disabledDays: {
          to: new Date()
        },
        startTimeValue: {
          HH: "12",
          mm: "00",
          ss: "00"
        },
        endTimeValue: {
          HH: "12",
          mm: "00",
          ss: "00"
        },
      }
    },

    methods: {
      showModal() {
        this.$modal.show('addTaskModal');
      },

      addTask() {
        this.loading = true;
        let formatedStartDateAndTime = this.formatedStartDate + ' ' + this.startTimeValue.HH + ':' + this.startTimeValue.mm + ':' + this.startTimeValue.ss;
        let formatedEndDateAndTime = this.formatedEndDate + ' ' + this.endTimeValue.HH + ':' + this.endTimeValue.mm + ':' + this.endTimeValue.ss;
        
        axios.post('/projects/' + this.project.id + '/tasks', 
          {
          'title': this.task.title, 
          'start': formatedStartDateAndTime, 
          'end': formatedEndDateAndTime
          })
          .then((data) => {
              this.$modal.hide('addTaskModal');
              events.$emit('addedtask', data.data);
              flash('New task has added successfully!', 'green');
              this.loading = false;
              this.task.title = '';
              this.startDate = null;
              this.endDate = null;
              this.startTimeValue = {
                HH: "12",
                mm: "00",
                ss: "00"
              },  
              this.endTimeValue = {
                HH: "12",
                mm: "00",
                ss: "00"
              }
            })
          .catch(error => this.loading = false);
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
