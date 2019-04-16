<template>

    <div  class="mb-2">
        <div class="flex flex-column m-1 px-3 pt-3 pb-1 bg-white flex-1 h-full overflow-auto">

            <h2 :class="loading ? 'loader' : ''" class="py-2 text-black text-lg font-bold">Today's Tasks</h2>
             
            <div v-if="todayTasks.length > 0" v-for="task in todayTasks" :key="task.id">
                <h3 class="text-xs">
                    <i v-if="task.completed" class="fas fa-feather-alt text-xs text-blue mr-1"></i>
                    <i v-if="!task.completed && !task.cancelled" class="fas fa-feather-alt text-xs text-orange-dark mr-1"></i>
                    <i v-if="task.cancelled" class="fas fa-bell-slash text-xs text-grey-dark mr-1"></i>
                    <span class="font-bold"> {{ task.project.title }} </span> - 
                    <span class="text-xs italic"> "{{ task.title }}" </span> 
                    <span class="text-grey"> 
                        &nbsp; ({{ time(task.start) }} - 
                        {{ time(task.end) }})
                    </span>
                </h3>
            </div>
             
            <div v-if="!loading && todayTasks.length == 0" class="text-black text-normal px-1">
                <h3 class="text-xs">
                    <span class="text-xs italic">Easy day...</span>
                    <i class="far fa-smile-wink text-lg text-blue ml-1"></i>
                </h3>
            </div>
            
        
        </div>
    </div>
    
</template>

<script>
import moment from 'moment';

export default {

    created() {
        this.loading = true;
        axios.get(`/today-tasks`)
            .then((data) => {
                this.todayTasks = data.data;
                this.loading = false;
            })
            .catch(error => {
                this.loading = false;
        });

        window.Echo.channel('tasks').listen('TaskCreated', e => {
            axios.get(`/today-tasks`)
                .then((data) => {
                    this.todayTasks = data.data;
                    this.loading = false;
                    flash( `${e.activity.user.name} has created a new task!`, 'green');
                })
                .catch(error => {
                    this.loading = false;
            });
        });

        window.Echo.channel('tasks').listen('TaskUpdated', e => {
            axios.get(`/today-tasks`)
                .then((data) => {
                    this.todayTasks = data.data;
                    this.loading = false;
                    if (e.task.completed == true) {
                    flash( `${e.activity.user.name} has completed the task!`, 'green');          
                    } else {
                    flash( `${e.activity.user.name} has updated the task!`, 'green'); 
                    }                    
                })
                .catch(error => {
                    this.loading = false;
            });
        });

        window.Echo.channel('projects').listen('ProjectSoftDeleted', e => {
            axios.get(`/today-tasks`)
                .then((data) => {
                    this.todayTasks = data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
            });
        });

    },

    data() {
        return {
            todayTasks: [],
            loading: false
        }
    },

    methods: {
        time(date) {
            return moment(date).format('HH:mm')
        },
    }
    
}
</script>
