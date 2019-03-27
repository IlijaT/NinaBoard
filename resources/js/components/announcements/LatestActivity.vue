<template>
    <div style="height:400px" class="my-1">

        <div class="flex flex-column m-1 p-3 bg-white flex-1 h-full overflow-auto">

            <h2 :class="loading ? 'loader' : ''" class="py-2 text-black text-lg font-bold">Latest Updates</h2>
            
            <ul v-if="activities.length > 0" class="text-xs list-reset">
                <li class="flex items-start content-start mb-1" v-for="activity in activities" :key="activity.id">

                    <div v-if="activity.description == 'completed_task'">
                        <img class="rounded-full h-4 w-4 mr-1" 
                        :src="activity.user.avatar_path" 
                        >                    
                        {{ activity.user.name }} completed <span class="text-xs italic mr-1">"{{ activity.subject.title }}"</span>
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'created_project'">
                        {{ activity.user.name }}  <span class="text-xs mr-1"> created new announcement </span>
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'created_task'">
                        {{ activity.user.name }} created task <span class="italic text-xs mr-1">"{{ activity.subject.title }}"</span>
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'deleted_task'">
                        {{ activity.user.name }} deleted a task  
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'incompleted_task'">
                        {{ activity.user.name }} changed <span class="italic text-xs mr-1">"{{ activity.subject.title }}"</span>
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'updated_project'">
                        {{ activity.user.name }} updated the announcement 
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                </li>
            </ul>
        
        </div>
    </div>
</template>


<script>
import moment from 'moment';

export default {

    created() {
        this.loading = true;
        axios.get(`/last-activity`)
        .then((data) => {
            this.activities = data.data;
            this.loading = false;
          })
        .catch(error => {
            this.loading = false;
        });
    },

    data() {
        return {
            activities: [],
            loading: false
        }
    },

    methods: {
        diffforhumans(dateCreated) {
            return moment(dateCreated).fromNow()
      },
    }
    
}
</script>