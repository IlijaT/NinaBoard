<template>

    <div  class="mb-2">
        <div class="flex flex-column m-1 px-3 pt-3 pb-1 bg-white flex-1 h-full overflow-auto">

            <h2 :class="loading ? 'loader' : ''" class="py-2 text-black text-lg font-bold">Today's Tasks</h2>
             
            <div v-if="todayTasks.length > 0" v-for="task in todayTasks" :key="task.id">
                <h3 class="text-xs">
                    <i v-if="task.completed" class="fas fa-feather-alt text-xs text-blue mr-1"></i>
                    <i v-else class="far fa-bell text-xs text-orange-dark mr-1"></i>
                    <span class="font-bold"> {{ task.project.title }} </span> - 
                    <span class="text-xs italic"> "{{ task.title }}" </span> 
                    <span class="text-grey"> 
                        &nbsp; ({{ time(task.start) }} - 
                        {{ time(task.end) }})
                    </span>
                </h3>
            </div>
             
            <div v-else class="text-black text-normal px-1">
                <div class="flex items-center">
                    Easy day...  
                    <i class="far fa-laugh-wink text-2xl text-blue ml-2"></i>
                </div>
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
            console.log(error);
            this.loading = false;
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
