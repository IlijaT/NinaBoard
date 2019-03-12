<template>
  <div class="mt-5 w-full">

    <div class="flex py-2 justify-end w-full my-2">

      <!-- <div class="flex">
        <select v-model="selectedFilter"  class="custom-select" id="inputGroupSelect02">
          <option v-for="option in options" :value="option.value" :key="option.value">
            {{ option.text }}
          </option>
        </select>
        <div class="input-group-append">
          <label @click="filter" class="input-group-text btn bg-blue hover:bg-blue-dark" for="inputGroupSelect02">
            <i class="fas fa-search text-normal text-white"></i>
          </label>
        </div>
      </div> -->
      <button class="bg-grey text-normal btn rounded-full text-white hover:bg-grey-darker" @click="showFilterModal">
        Filter
        <i class="fas fa-search text-lg text-white ml-2"></i>
      </button>


      <!-- modal -->
      <modal adaptive name="filterModal" height="auto" width="660">
        <div class="flex flex-column h-full m-2">

          <div class="my-2 text-center border-b-2 border-grey-light">
            <h3 class="text-grey text-2xl font-normal">Filter data</h3>
          </div>
          <div class="flex justify-between mx-2 my-3">
            <datepicker
            :inline="true"
            :mondayFirst="true"
            @selected="selectedStartDate"
            bootstrap-styling
            v-model="startDate">
            </datepicker>
            
            <datepicker
              :inline="true"
              :mondayFirst="true"
              v-model="endDate"
              :disabled="true"
              :disabled-dates="disabledEndDates">
            </datepicker>
          </div>

          <div class="flex m-2">
            <select v-model="selectedFilter"  class="custom-select" id="inputGroupSelect02">
              <option v-for="option in options" :value="option.value" :key="option.value">
              {{ option.text }}
              </option>
            </select>
            <div class="input-group-append">
              <label class="input-group-text btn bg-grey-light" for="inputGroupSelect02">
              <i class="fas fa-filter text-normal text-black"></i>
              </label>
            </div>
          </div>
            
          <div class="flex m-2 mt-4">
            <div class="ml-auto control flex">
              <button @click="$modal.hide('filterModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-full py-1 px-4 border-1 border-grey">Cancel</button>
              <button 
                @click="filter"
                :disabled="! startDate || ! endDate"
                :class="loading ? 'loader' : ''"
                class="btn py-1 px-4 text-lg button rounded-full text-white hover:bg-blue-dark hover:border-blue-dark  border-2 border-blue"
                >Filter</button>
            </div> 
          </div> 

        </div>

      </modal>
        
       
    </div>

    <table class="bg-white shadow-md table table-striped table-sm table-responsive">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Client</th>
          <th scope="col">Task</th>
          <th scope="col">Action</th>
          <th scope="col">Date</th>
        </tr>
      </thead>
      <tbody >
        <tr v-if="tableData" v-for="item in tableData" :key="item.id">
          <th scope="row">{{ item.id }}</th>
          <td>{{ item.client }}</td>
          <td>{{ item.task }}</td>
          <td>{{ item.action }}</td>
          <td>{{ item.date }}</td>
        </tr>
        <tr v-if="tableData.length < 1 || tableData == undefined">
          <th scope="row">Empty table</th>
        </tr>
      </tbody>
    </table>
    <paginator :dataSet="dataSet" @updated="filter"></paginator>
  </div>
</template>

<script>

import Datepicker from 'vuejs-datepicker';
import moment from 'moment';


  export default {
    components: { Datepicker },
    props: ['user'],
    data() {
      return {
        loading: false,
        startDate: '',
        endDate: '',
        disabledEndDates: {
          to: new Date(2023, 0, 1),
        },

        selectedFilter: 'completed_task',

        options: [
          { text: 'Completed Tasks', value: 'completed_task' },
          { text: 'Incompleted Tasks', value: 'incompleted_task' },
          { text: 'Created Tasks', value: 'created_task' },
          { text: 'Created Announcements', value: 'created_project' },
          { text: 'Updated Announcements', value: 'updated_project' }
        ],

        dataSet: false,
        tableData: []
      }
    }, 
    methods: {
      showFilterModal() {
        this.$modal.show('filterModal');
      },
      selectedStartDate(date) {
        this.disabledEndDates.to = new Date(moment(date).format('YYYY-MM-DD'));
      },

      filter(page) {
        this.tableData = [];
        this.loading = true;
        axios.get(this.url(page), { params: { start: this.startDate, end: this.endDate, selected: this.selectedFilter}})
          .then((data) => {

            this.dataSet = data.data;
           
            data.data.data.forEach(element => {
              this.tableData.push({
                  'id': (this.dataSet.current_page == 1 ? 0 : ((this.dataSet.current_page - 1) * this.dataSet.per_page)) + (data.data.data.indexOf(element) + 1),
                  'client': element.subject_type == 'App\\Project' ? element.subject.title : element.subject.project.title,
                  'task': element.subject_type == 'App\\Project' ? '/' : element.subject.title, 
                  'action': element.description.replace("_", " "), 
                  'date': element.created_at,
                });
            });

            this.loading = false;
            this.$modal.hide('filterModal');
          })
          .catch(error => { 
            this.tableData = [];
            this.loading = false;
            this.startDate = '';
            this.endDate = '';
            this.$modal.hide('filterModal');
          });
      },

      url(page = 1) {
        // '/users/' + this.user.id + '/activity'
        return `${location.pathname}/activity?page=${page}`;
      },
    },

  }
</script>