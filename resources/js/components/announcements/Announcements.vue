<template>
    <div class="lg:flex lg:flex-wrap mt-4 -mx-2">
             
        <div  class="lg:w-1/3 px-2 pb-4" v-for="announcement in filteredAnnouncements" :key="announcement.id">
            <announcement :logged="logged" :project="announcement"></announcement>
        </div>
           
    </div>
</template>

<script>

import Announcement from './Announcement.vue';

export default {
    props:['projects', 'logged'],

    components: { Announcement },

    created() {
        this.announcements = this.projects;
        events.$on('search', (data) => this.searchTerm = data);
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
    

}
</script>

