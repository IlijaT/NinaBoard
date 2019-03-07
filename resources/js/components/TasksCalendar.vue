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

        <calendar-event-modal></calendar-event-modal>
    </div>
    
    
</div>
  
</template>

<script>

  import CalendarEventModal from '../modals/CalendarEventModal.vue';

  export default {
    components: { CalendarEventModal },

    props: ['tasks'],

    created() {
      this.tasks.forEach(task => {
        
        this.events.push(
            {
              'id'        : task.id,
              'title'     : task.project.title + ' : ' + task.title,
              'start'     : task.start, 
              'end'       : task.end, 
              'color'     : task.completed == 1 ? '#1f9d55' : '#de751f',
              'completed' : task.completed,
              'textColor' : 'white',
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
          slotLabelFormat: 'HH:mm',
          eventClick:  (calEvent) => {

            this.$modal.show('calendarModal', {'task': calEvent} );

          }
        },
      }
    }

  }
</script>
