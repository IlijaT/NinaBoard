<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-md">
                <div class="card-header text-xl">Tasks Calendar</div>
                  
                <div class="card-body">
                    <full-calendar :events="events" :config="config"></full-calendar>
                </div>

            </div>
        </div>
    </div>
</div>
  
</template>

<script>

  export default {
    props: ['tasks'],
    created() {
      this.tasks.forEach(task => {
        this.events.push(
            {
              'title' : task.project.title + ' : ' + task.title,
              'start' : task.start, 
              'end' : task.end, 
              'color': task.completed == 1 ? 'purple' : 'green',
              'textColor': 'white',
            }
          );
      }); 
 
       
    },
    data() {
      return {
        events: [],
        config: {
          allDaySlot: false,
          editable: false,
          firstDay: 1,
          //height: 'auto',
          slotDuration: '00:15:00',
          scrollTime: '12:00:00',
          slotLabelFormat: 'HH:mm'
        },
      }
    }
  }
</script>
