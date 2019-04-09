<template>
    <div style="height:500px" class="my-2">

        <div class="flex flex-column m-1 p-3 bg-white flex-1 h-full overflow-auto">

            <h2 :class="loading ? 'loader' : ''" class="py-2 text-black text-lg font-bold">Latest Updates</h2>
            
            <ul v-if="activities.length > 0" class="text-xs list-reset">
                <li class="flex items-start content-start mb-1" v-for="activity in activities" :key="activity.id">

                    <div v-if="activity.description == 'completed_task'">
                        <span class="text-normal font-bold">{{ activity.user.name }}</span>                   
                         completed <span class="text-xs italic mr-1">"{{ activity.subject.title }}"</span>
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'created_project'">
                        <span class="text-normal font-bold">{{ activity.user.name }}</span>    
                        <span class="text-xs mr-1"> created new announcement </span>
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'created_task'">
                        <span class="text-normal font-bold">{{ activity.user.name }}</span>    
                        created task <span class="italic text-xs mr-1">"{{ activity.subject.title }}"</span>
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'deleted_task'">
                        <span class="text-normal font-bold">{{ activity.user.name }}</span> 
                        deleted a task  
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'incompleted_task'">
                        <span class="text-normal font-bold">{{ activity.user.name }}</span> 
                        changed <span class="italic text-xs mr-1">"{{ activity.subject.title }}"</span>
                        <span class="text-grey text-xs">{{ diffforhumans(activity.created_at)  }}</span>
                    </div>
                    <div v-if="activity.description == 'updated_project'">
                        <span class="text-normal font-bold">{{ activity.user.name }}</span> 
                        updated the announcement 
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
        this.getActivities();
        window.Echo.channel('projects').listen('ProjectCreated', e => {
            this.getActivities();
        });
        window.Echo.channel('projects').listen('ProjectUpdated', e => {
            this.getActivities();
        });
        window.Echo.channel('tasks').listen('TaskCreated', e => {
            this.getActivities();
        });
         window.Echo.channel('tasks').listen('TaskUpdated', e => {
            this.getActivities();
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
        getActivities() {
            axios.get(`/last-activity`)
                .then((data) => {
                    this.activities = data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
            });
        }
    }
    
}
</script>