<template>
    <div @click="changeLocation" class="flex flex-col bg-white px-4 pt-4 pb-3 card" style="height: 260px; cursor:pointer;">

        <div 
            :class="computeColor()"
            class="font-normal mb-2 text-normal pl-4 py-2 -ml-6 border-l-4  pl-2">
                {{  announcement.title.substr(0, 50)  }}
            <span class="text-grey text-xs">{{ diffforhumans(announcement.created_at) }}</span>
        </div>

        
        <div style="overflow: hidden;" class="text-grey-darker text-xs mb-2" v-html="announcement.description.substr(0, 200)">
             
        </div>
       
        <div class="flex justify-center mt-auto items-end">
            
            <div class="text-grey text-xs font-normal mr-2">
                <i class="fas fa-bullhorn text-xs text-grey"></i>
                {{ this.announcement.tasks ? this.announcement.tasks.length : 0 }}
            </div>
            <div class="text-grey text-xs font-normal">
                <i class="fas fa-feather-alt text-xs text-grey"></i>
                {{ finishedTasksCount }}
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
        if(typeof this.project.tasks == "undefined") {
            this.announcement.tasks = [];
        } else {
            this.announcement.tasks = this.project.tasks;
        }
        
        window.Echo.channel('tasks').listen('TaskCreated', e => {
            if(this.announcement.id == e.task.project_id){
                //window.location.reload()
                this.onBroadcastTaskCreated(e);
            }
        });

        window.Echo.channel('tasks').listen('TaskUpdated', e => {
            if(this.announcement.id == e.task.project_id){
                this.onBroadcastTaskUpdated(e);
            }
        });
    },
    data() {
        return {
            announcement: {
                tasks : []
            },
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
        },
        onBroadcastTaskCreated(e) {
            this.announcement.tasks.push(e.task);
            this.$forceUpdate();
        },
        onBroadcastTaskUpdated(e) {
            var item = this.announcement.tasks.find((element) => {return element.id == e.task.id });

            item.completed = e.task.completed;
            item.created_at = e.task.created_at;
            item.deleted_at = e.task.deleted_at;
            item.end = e.task.end;
            item.id = e.task.id;
            item.project_id = e.task.project_id;
            item.start = e.task.start;
            item.title = e.task.title;
            item.updated_at = e.task.updated_at;
            
            window.location.reload();
        }
    },
    computed: {
        finishedTasksCount() {
            let completed = this.announcement.tasks.filter((item) => item.completed );
            return completed.length;
        }, 
    },
}
</script>

