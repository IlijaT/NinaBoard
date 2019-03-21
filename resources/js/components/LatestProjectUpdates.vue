<template>
  <div  class="flex flex-column mx-0 mt-1 px-3 pt-3 pb-1 bg-white">
    <h2 class="py-2 text-black text-lg font-bold">Latest Tasks Updates</h2>
      <ul class="text-xs list-reset">
        <li v-for="activity in projectActivities" :key="activity.id">

          <div v-if="activity.description == 'completed_task'">
            {{ activity.user.name }} completed <span class="text-xs italic">"{{ activity.subject.title }}"</span>
          </div>
          <div v-if="activity.description == 'created_project'">
            {{ activity.user.name }}  <span class="text-xs"> created new announcement </span>
          </div>
          <div v-if="activity.description == 'created_task'">
            {{ activity.user.name }} created task <span class="italic text-xs">"{{ activity.subject.title }}"</span>
          </div>
          <div v-if="activity.description == 'deleted_task'">
            {{ activity.user.name }} deleted <span class="italic text-xs">"{{ activity.subject.title }}"</span>
          </div>
          <div v-if="activity.description == 'incompleted_task'">
            {{ activity.user.name }} incompleted <span class="italic text-xs">"{{ activity.subject.title }}"</span>
          </div>
          <div v-if="activity.description == 'updated_project'">
             {{ activity.user.name }} updated the announcement 
          </div>
          <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>

      </li>
    </ul>
  </div>
</template>

<script>
  import moment from 'moment';

  export default {
    props: ['activities'],

    data() {
      return {
        projectActivities: []
      }
    },

    created() {
      this.projectActivities = this.activities;
      events.$on('updatednote', (data) => this.projectActivities = data);
      events.$on('updatedproject', (data) => this.projectActivities = data.activities);

    },

    methods: {
    diffforhumans(dateCreated) {
      return moment(dateCreated).fromNow()
    },
    }

  }
</script>

