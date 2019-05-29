<template>
  <div>
    
    <!-- modal -->
    <modal @before-open="beforeOpen" :adaptive="true" :draggable="true" name="editTaskModal" :height="590" :width="650">
        <form class="p-10 flex flex-column h-full" @submit.prevent="editTask">

            <header class="section py-6 mb-2" style="background: url('/images/splash.svg') 190px 4px no-repeat;">
              <h1 class="text-black text-center text-2xl mb-4">Edit Task</h1>
            </header>

            <label class="label text-sm mb-2 block" for="title">Task</label>
            <div class="control mb-2">
              <input
                  type="text"
                  class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                  name="title"
                  placeholder="Task title..."
                  v-model="taskForEditing.title"
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
                  :placeholder="placeholderStart()"
                  @selected="selectedStartDate"
                  v-model="startDate">
                  </datepicker>
           
                  <div class="mt-2">
                    <label class="label text-sm mb-2 block">Start time</label>
                    <vue-timepicker :hide-clear-button="true" :minute-interval="10" v-model="startTimeValue"></vue-timepicker>
                  </div>

                </div>

                <div class="flex-1 ml-1">
                  <datepicker
                    :mondayFirst="true"
                    :bootstrap-styling="true"
                    :placeholder="placeholderEnd()"
                    :disabled="! startDate"
                    @selected="selectedEndDate"
                    :disabledDates="disabledDays"
                    v-model="endDate">
                  </datepicker>

                  <div class="mt-2">
                    <label class="label text-sm mb-2 block">End time</label>
                    <vue-timepicker :hide-clear-button="true" :minute-interval="10" v-model="endTimeValue"></vue-timepicker>
                  </div>
                  
                </div>

              </div>

            </div>

            <div class="control mb-2">
              <label class="label text-sm mb-2 block">Cancel Task</label>
              <div class="input-group mt-2 mb-3">
                
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Options</label>
                </div>
                <select 
                  class="custom-select" id="inputGroupSelect01"
                  v-model="taskForEditing.cancelled">
                  <option value="">Aktivno</option>
                  <option>Najava nije emitovana</option>
                  <option>Najava je odlozena</option>
                  <option>Emisija nije emitovana</option>
                  <option>Medij nije u pracenju</option>
                  <option>Nije snimljeno</option>
                  <option>Greškom upisano</option>
                </select>
              </div>
            </div>

            <div class="flex mt-auto">
              <div class="ml-auto control flex">
                <button @click.prevent="$modal.hide('editTaskModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
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

    data(){
      return {
        loading: false,
        taskForEditing: {},
        startDate: '',
        formatedStartDate: '',
        formatedEndDate: '',
        endDate: '',
        disabledDays: {
          to: new Date()
        },
        startTimeValue: {
          HH: '00',
          mm: "00",
          ss: "00"
        },
        endTimeValue: {
          HH: "00",
          mm: "00",
          ss: "00"
        },

      }
    },

    methods: {
        beforeOpen(event) {
            this.taskForEditing = event.params.taskForEditing;
            this.formatedStartDate = moment(event.params.taskForEditing.start).format('YYYY-MM-DD');
            this.formatedEndDate = moment(event.params.taskForEditing.end).format('YYYY-MM-DD');
            this.startTimeValue.HH = moment(event.params.taskForEditing.start).format('HH');
            this.startTimeValue.mm = moment(event.params.taskForEditing.start).format('mm');
            this.endTimeValue.HH = moment(event.params.taskForEditing.end).format('HH');
            this.endTimeValue.mm = moment(event.params.taskForEditing.end).format('mm');

        },
        placeholderStart(){
            return moment(this.taskForEditing.start).format('DD MMM YYYY');
        },
        placeholderEnd(){
            return moment(this.taskForEditing.end).format('DD MMM YYYY');
        },
     

        editTask() {
            this.loading = true;
            let formatedStartDateAndTime = this.formatedStartDate + ' ' + this.startTimeValue.HH + ':' + this.startTimeValue.mm + ':' + this.startTimeValue.ss;
            let formatedEndDateAndTime = this.formatedEndDate + ' ' + this.endTimeValue.HH + ':' + this.endTimeValue.mm + ':' + this.endTimeValue.ss;
            
            axios.patch('/projects/' + this.taskForEditing.project_id + '/tasks/' + this.taskForEditing.id, 
                {
                'title': this.taskForEditing.title, 
                'cancelled': this.taskForEditing.cancelled,
                'start': formatedStartDateAndTime, 
                'end': formatedEndDateAndTime
                })
                .then((data) => {
                    this.$modal.hide('editTaskModal');
                    events.$emit('editedtask', data.data);
                    flash('The task has been updated successfully!', 'green');
                    this.loading = false;
                    this.task = {};
                    this.startDate = null;
                    this.endDate = null;
                    this.formatedStartDate = '',
                    this.formatedEndDate = '',
                    this.startTimeValue = { HH: "00", mm: "00", ss: "00"},  
                    this.endTimeValue = { HH: "00", mm: "00", ss: "00"}
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
