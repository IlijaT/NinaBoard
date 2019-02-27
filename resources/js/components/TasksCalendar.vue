<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-md">
                <div class="card-header text-xl">Tasks Calendar</div>
                  
                <div class="card-body">
                    <full-calendar :events="events"></full-calendar>
                </div>

            </div>
        </div>
    </div>
</div>
  
</template>

<script>

  export default {
    props: ['tasks'],
    data() {
      return {
        events: this.tasks
      }
    }
  }
</script>
