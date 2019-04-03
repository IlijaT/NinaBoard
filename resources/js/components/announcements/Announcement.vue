<template>
    <div @click="changeLocation" class="flex flex-col bg-white px-4 pt-4 pb-3 card" style="height: 260px; cursor:pointer;">

        <div 
            :class="computeColor()"
            class="font-normal mb-2 text-normal pl-4 py-2 -ml-6 border-l-4  pl-2">
                {{  announcement.title.substr(0, 50)  }}
            <span class="text-grey text-xs">{{ diffforhumans(announcement.created_at) }}</span>
        </div>

        
        <div style="overflow: hidden;" class="text-grey text-xs mb-2" v-html="announcement.description.substr(0, 200)">
             
        </div>
       
        <div class="flex justify-center mt-auto items-end">
            
            <div class="text-grey text-xs font-normal mr-2">
                <i class="fas fa-bullhorn text-xs text-grey"></i>
                {{ announcement.tasks ? announcement.tasks.length : 0 }}
            </div>
            <div class="text-grey text-xs font-normal">
                <i class="fas fa-feather-alt text-xs text-grey"></i>
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
        computeColor(){
            if(! this.announcement.tasks) {
                return 'border-blue-light';
            }
            if(this.announcement.tasks.length == this.finishedTasksCount) {
                return 'border-blue-light';
            }
            return 'border-orange-dark';
        },

        changeLocation(){
            window.location.href =`/projects/${this.announcement.id}`;
        }
    },
    computed: {
        finishedTasksCount() {
            if(! this.announcement.tasks) {
                return 0;
            }
            let completed = this.announcement.tasks.filter((item) => item.completed );
            return completed.length;
        }
    }
}
</script>

