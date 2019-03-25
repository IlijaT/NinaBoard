<template>
    <div class="flex flex-col bg-white px-4 pt-4 pb-3 card" style="height: 260px">

        <div 
            :class="announcement.tasks.length == this.finishedTasksCount ? 'border-blue-light' : 'border-orange-dark'"
            class="font-normal mb-2 text-normal pl-4 py-2 -ml-6 border-l-4  pl-2">
            <a style="text-decoration: none" class="text-black" :href="`/projects/${announcement.id}`">
                {{  announcement.title.substr(0, 50)  }}
            </a>
            <div class="text-grey text-xs">{{ diffforhumans(announcement.created_at) }}</div>
        </div>

        
        <div class="text-grey text-xs mb-2">
            {{  announcement.description.substr(0, 90) }}...
        </div>
       
        <div class="flex justify-center mt-auto items-end">
            
            <div class="text-grey text-xs font-normal mr-2">
                <i class="far fa-list-alt text-xs text-grey-dark"></i>
                {{ announcement.tasks.length }}
            </div>
            <div class="text-grey text-xs font-normal">
                <i class="far fa-check-circle text-xs text-grey-dark"></i>
                {{ this.finishedTasksCount }}
            </div>
         
        </div>
        
        
    </div>

</template>

<script>
import moment from 'moment';

export default {
    props: ['project'],

    created() {
        this.announcement = this.project;
    },
    data() {
        return {
            announcement: {}
        }
    },
    methods: {
        diffforhumans(date) {
            return moment(date).format('DD MMM YYYY')
        },
    },
    computed: {
        finishedTasksCount() {
            let completed = this.announcement.tasks.filter((item) => item.completed );

            return completed.length;
        }
    }
}
</script>

