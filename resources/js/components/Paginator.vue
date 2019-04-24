<template>
    <div class="flex justify-between items-center">

      <div clas="flex" v-show="lastPage > 1">
        <h3 class="text-normal text-black text-sm">
          Showing {{ page * perPage - perPage + 1}} to {{ page == lastPage ? total : page * perPage }} of total {{ total }} items
        </h3>
      </div>

      <div class="ml-auto">
        <ul v-if="shouldPaginate" class="pagination justify-content-end">
          <li v-show="prevUrl" class="page-item">
          <a class="page-link text-normal text-grey-darkest" href="#" @click.prevent="page--" rel="prev">
            <i class="far fa-hand-point-left text-normal text-grey-darkest mr-1"></i>
            Previous
          </a>
          </li>
          <li v-show="nextUrl" class="page-item">
            <a class="page-link text-normal text-grey-darkest" href="#" @click.prevent="page++" rel="next">
              Next
              <i class="far fa-hand-point-right text-normal text-grey-darkest ml-1"></i>
            </a>
          </li>
        </ul>
      </div>

    </div>

</template>

<script>
  export default {
    props: ['dataSet'],
    data() {
      return {
        lastPage: 1,
        page: 1,
        prevUrl: false,
        nextUrl: false,
        total: 0,
        perPage: 0

      }
    },
    watch: {
      dataSet(){
        this.lastPage = this.dataSet.last_page;
        this.page = this.dataSet.current_page;
        this.prevUrl = this.dataSet.prev_page_url;
        this.nextUrl = this.dataSet.next_page_url;
        this.total = this.dataSet.total;
        this.perPage = this.dataSet.per_page;
      },
      page() {
        this.broadcast();
      }
    },
    computed: {
      shouldPaginate(){
        return !! this.prevUrl || !! this.nextUrl;
      }
    },

    methods: {
      broadcast() {
        this.$emit('updated', this.page);
      }
    },
  }
</script>
