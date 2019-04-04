<template>
    <div class="lg:flex lg:flex-wrap mt-4 -mx-2">
             
        <div  class="lg:w-1/3 px-2 pb-4" v-for="announcement in filteredAnnouncements" :key="announcement.id">
            <announcement :project="announcement"></announcement>
        </div>
           
    </div>
</template>

<script>

import Announcement from './Announcement.vue';

export default {
    props:['projects'],

    components: { Announcement },

    created() {
        this.announcements = this.projects;
        events.$on('search', (data) => this.searchTerm = data);
        window.Echo.channel('projects').listen('ProjectCreated', e => {
            this.announcements.unshift(e.project);
            flash( `${e.activity.user.name} has created a new announcement!`, 'green');
        });
        window.Echo.channel('projects').listen('ProjectUpdated', e => {
            this.onUpdate(e.project);
            flash( `${e.activity.user.name} has updated the announcement`, 'green');
        });
        window.Echo.channel('projects').listen('ProjectSoftDeleted', e => {
            this.onDelete(e.project);
            flash( `The announcement '${e.project.title}' has been archived`, 'green');
        });

    },
    data() {
        return {
            announcements: [],
            searchTerm: ''
        }
    },
    computed: {
        filteredAnnouncements() {
            return this.announcements.filter((ann) => {
                return ann.title.toLowerCase().match(this.searchTerm.toLowerCase()) || 
                    ann.description.toLowerCase().match(this.searchTerm.toLowerCase());
            })
        }
    },

    methods: {
        onUpdate(project) {
            var item = this.announcements.find((element) => {return element.id == project.id });
            this.announcements.splice(this.announcements.indexOf(item), 1);
            let newItem = project;
            this.$nextTick(function () {
                this.announcements.unshift(newItem);
            })
            
         },
        onDelete(project) {
            var item = this.announcements.find((element) => {return element.id == project.id });
            this.announcements.splice(this.announcements.indexOf(item), 1);
         }
    },
    

}
</script>

