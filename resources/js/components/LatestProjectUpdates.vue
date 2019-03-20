<template>

<ul class="text-xs list-reset">
  <li v-for="item in activity" :key="item.id" class="mb-1">

      <span class="text-grey text-xs">{{ diffforhumans(item.created_at)  }}</span>
  </li>
</ul>

</template>

<script>
  import moment from 'moment';

  export default {
    props: ['project'],

    data() {
      return {
        activity: []
      }
    },

    created() {
      this.activity = this.project;
    },

      methods: {
      diffforhumans(dateCreated) {
        return moment(dateCreated).fromNow()
      },
    }

  }
</script>

