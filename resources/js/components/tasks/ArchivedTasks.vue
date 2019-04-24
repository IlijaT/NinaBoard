<template>
  <div class="mt-3 w-full">

    <div class="flex py-2 justify-end w-full my-2">

      <button download :disabled="!dataSet" @click="exportExcel" class="mr-2 bg-blue-darker text-normal btn rounded-lg text-white
      ">
        Export
      <i class="far fa-file-excel text-normal text-white ml-2"></i>
      </button>
      <button class="bg-blue-darker text-normal btn rounded-lg text-white hover:bg-blue-darker" @click="showFilterModal">
        Filter
        <i class="fas fa-search text-normal text-white ml-2"></i>
      </button>


      <!-- modal -->
      <modal adaptive name="filterModal" height="auto" :width="740">
        <div class="p-10 flex flex-column">

          <header class="section mb-2">
            <div class="text-black text-center text-2xl mb-2">Search Archived Tasks</div>
          </header>
          
          <div class="control mb-2">
            <label class="label text-sm block">Client name</label>
            <input
                type="text"
                class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                placeholder="Client name..."
                v-model="name"
                required
                >
          </div>
          
          <div class="control mb-2">
            <label class="label text-sm block">Select tasks status</label>
            <select v-model="selectedFilter"  class="custom-select text-xs" id="inputGroupSelect02">
              <option  v-for="option in options" :value="option.value" :key="option.value">
              <span class="text-sm">{{ option.text }}</span>
              </option>
            </select>
          </div>

          <div class="control mb-2">
            <label class="label text-sm block">Choose dates</label>
            <div class="flex justify-between mb-2">
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
          </div>

          


          <div class="flex py-4">
            <div class="ml-auto control flex">
              <button @click="$modal.hide('filterModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
              <button
                @click.prevent="filter"
                :disabled="! startDate || ! endDate"
                :class="loading ? 'loader' : ''"
                class="btn py-1 px-4 text-lg button rounded-lg text-white hover:bg-blue-dark hover:border-blue-dark  border-2 border-blue"
                >Filter</button>
            </div>
          </div>
        </div>

      </modal>


    </div>

    <table  class="table table-sm table-responsive  lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
      <thead class="bg-grey-light text-black">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Client</th>
          <th scope="col">Task</th>
          <th scope="col">Completed</th>
          <th scope="col">Cancelled</th>
          <th scope="col">Date</th>
        </tr>
      </thead>
      <tbody class="text-xs">
        <tr v-if="tableData" v-for="item in tableData" :key="item.id">
          <th scope="row">{{ item.id }}</th>
          <td>{{ item.client }}</td>
          <td>{{ item.task }}</td>
          <td>{{ item.completed }}</td>
          <td>{{ item.cancelled }}</td>
          <td>{{ item.date }}</td>
        </tr>
        <tr v-if="tableData.length < 1 || tableData == undefined">
          <th colspan="5" scope="row" class="p-2 text-grey-dark">Empty table</th>
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
        name: '',
        startDate: '',
        endDate: '',
        disabledEndDates: {
          to: new Date(2023, 0, 1),
        },

        selectedFilter: 'completed',

        options: [
          { text: 'Completed Tasks', value: 'completed' },
          { text: 'Cancelled Tasks', value: 'cancelled' },
          { text: 'All', value: 'all' },
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
        axios.get(this.url(page), { params: { name: this.name, start: this.startDate, end: this.endDate, selected: this.selectedFilter}})

          .then((data) => {
            this.dataSet = data.data;
            data.data.data.forEach(element => {
                this.tableData.push({
                  'id': (this.dataSet.current_page == 1 ? 0 : ((this.dataSet.current_page - 1) * this.dataSet.per_page)) + (data.data.data.indexOf(element) + 1),
                  'client': element.project.title,
                  'task': element.title,
                  'completed': element.completed == 1 ? 'completed' : '/',
                  'cancelled': element.cancelled == null ? '/' : element.cancelled,
                  'date': moment(element.created_at).format('DD.MM.YYYY.') 
                });
            });
            this.loading = false;
            this.$modal.hide('filterModal');
          })
          .catch(error => {
            this.tableData = [];
            this.loading = false;
            this.name = '';
            this.startDate = '';
            this.endDate = '';
            this.$modal.hide('filterModal');
          });
      },

      url(page = 1) {
        return `${location.pathname}/tasks?page=${page}`;
      },
      exportExcel() {

        axios.get(`${location.pathname}/tasks/export?`, { params: { name: this.name, start: this.startDate, end: this.endDate, selected: this.selectedFilter}})
          .then(response => 
            window.location =  response.request.responseURL)
          ;

      },
    },

  }
</script>