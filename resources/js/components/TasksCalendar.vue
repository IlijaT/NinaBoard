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
    </div>
  </div>
  
</template>

<script>

  export default {
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
              'title'     : task.project.title + ' - ' + task.title,
              'start'     : task.start, 
              'end'       : task.end, 
              'color'     : task.completed == 1 ? '#38a4cc' : task.cancelled ? '#8795a1' : '#de751f',
              'completed' : task.completed,
              'textColor' : 'white',
              'project'   : task.project,
            }
          );
      });
      events.$on('showpopup', (data) => this.showpopup(data));
      events.$on('closepopup', (data) => this.closepopup(data));
    },

    data() {
      return {
        events: [],
        timer: null,
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
            window.location.href =`/projects/${calEvent.project.id}`;
          },
          eventRender: function(eventObj, el) {
           
           $(el).popover({
            trigger: "manual" , 
            title: eventObj.title,
            content: eventObj.project.description,
            html: true,
            placement: 'right',
            container: 'body',
            }).on("mouseenter", function () {
                var _this = this;
                events.$emit('showpopup', _this);
              }).on("mouseleave", function () {
                var _this = this;
                events.$emit('closepopup', _this);
            });
          },
        },
      }
    },

    methods: {
       showpopup(element) {
         $(element).css("border-color","#3d4852")
         this.timer = setTimeout(() => {$(element).popover("show");}, 550);
        $(".popover").on("mouseleave", function () {
          $(element).popover('hide');
        });
       },
       closepopup(element) {
          $(element).css("border-color","")
         clearTimeout(this.timer);
          if (!$(".popover:hover").length) {
              $(element).popover("hide");
          }
       }
      
    },
  }
</script>

<style>
.fc-event{
  cursor: pointer;
}
.popover-body {
      height: 200px;
      overflow-y: auto;
      white-space:pre-wrap;
  }
.popover-header {
     background:#314d70;
     color: #ffffff;
     font-weight: bold;
  }
</style>

