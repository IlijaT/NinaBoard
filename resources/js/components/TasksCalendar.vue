<template>
  <div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-xs-12">
         
            <div class="card shadow-md">
                <div class="card-body">
                    <full-calendar :events="events" :config="config"></full-calendar>
                </div>
            </div>
        </div>

        <calendar-event-modal @completed="completed"></calendar-event-modal>
    </div>
    
    
</div>
  
</template>

<script>

  import CalendarEventModal from '../modals/CalendarEventModal.vue';

  export default {
    components: { CalendarEventModal },

    props: {
      tasks: {
        type: Array,
        default: () => []
      }
    },
    created() {
      this.tasks.forEach(task => {
        
        this.events.push(
            {
              'id'        : task.id,
              'title'     : task.project.title + ' : ' + task.title,
              'start'     : task.start, 
              'end'       : task.end, 
              'color'     : task.completed == 1 ? '#38a4cc' : '#de751f',
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
          defaultView: 'month',
          themeSystem: 'bootstrap4',
          allDaySlot: false,
          editable: false,
          firstDay: 1,
          height: 700,
          slotDuration: '00:15:00',
          scrollTime: '12:00:00',
          slotLabelFormat: 'HH:mm',
          eventClick:  (calEvent) => {

            this.$modal.show('calendarModal', {'task': calEvent} );

          }
        },
      }
    },
    methods: {
      completed(task) {      
        let newItem = {
          'id'        : task.id,
          'title'     : task.project.title + ' : ' + task.title,
          'start'     : task.start, 
          'end'       : task.end, 
          'color'     : '#38a4cc',
          'completed' : task.completed,
          'textColor' : 'white',
        }
                     

        var index = this.events.findIndex(item => item.id === task.id)

        this.events.splice(index, 1, newItem);

        flash('Task has been completed!', 'green');

      }
    },

  }
</script>
