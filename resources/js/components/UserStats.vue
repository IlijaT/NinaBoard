<template>
  <div class="mt-5 w-full">

    <div class="flex py-2 justify-end w-full my-2">

      <div class="flex">
        <select v-model="selectedFilter"  class="custom-select" id="inputGroupSelect02">
          <option v-for="option in options" :value="option.value" :key="option.value">
            {{ option.text }}
          </option>
        </select>
        <div class="input-group-append">
          <label @click="filter" class="input-group-text btn bg-blue hover:bg-blue-dark" for="inputGroupSelect02"><i class="fas fa-search text-normal text-white"></i></label>
        </div>
      </div>
    </div>

    <table class="bg-white rounded-lg shadow-md table table-striped table-sm table-responsive">
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
        <tr v-if="tableData" v-for="item in tableData" :key="tableData.indexOf(item)">
          <th scope="row">{{ item.id }}</th>
          <td>{{ item.client }}</td>
          <td>{{ item.task }}</td>
          <td>{{ item.action }}</td>
          <td>{{ item.date }}</td>
        </tr>
        <tr v-if="!tableData">
          <th scope="row">No data</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    
    </table>
  </div>
</template>

<script>
  export default {
    props: ['user'],
    data() {
      return {
        selectedFilter: 'completed_task',
        options: [
          { text: 'Copleted tasks', value: 'completed_task' },
          { text: 'Incompleted tasks', value: 'incompleted_task' },
          { text: 'Created tasks', value: 'created_task' },
          { text: 'Created projects', value: 'created_project' }
        ],
        tableData: []
      }
    }, 

    methods: {
      filter() {
        this.tableData = [],
        axios.get('/users/' + this.user.id + '/activity')
          .then((data) => {
              //console.log(data.data);
              data.data.forEach(element => {
                this.tableData.push(
                  {
                    'id': data.data.indexOf(element) + 1,
                    'client': element.subject.project.title,
                    'task': element.subject.title, 
                    'action': element.description, 
                    'date': element.created_at,
                  }
                );

              });

              console.log(this.items);
            })
          .catch(error => this.loading = false);
      }
    },

  }
</script>