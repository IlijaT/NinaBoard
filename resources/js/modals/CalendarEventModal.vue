<template>
  <div>

      
    <modal adaptive name="calendarModal" :height="300" @before-open="beforeOpen">
        <div class="flex flex-column h-full  p-6" :class="{ color }">
            {{ title }} - 
             {{ start }}
              {{ end }}
        </div>
    </modal>
    
  </div>

</template>


<script>


export default {

    data() {
      return {
        title: '',
        color: '',
        start: '',
        end: '',
        completed: false,
      }
    },

    methods: {
      beforeOpen (event) {
        this.title = event.params.task.title;
        this.color = event.params.task.color;
        this.start = event.params.task.start.format("Do MMM  YYYY");
        this.end = event.params.task.end.format("Do MMM  YYYY");

        console.log(event.params.task);
        console.log(event.params.task.title);
        console.log(event.params.task.start.format("Do MMM  YYYY"));
        console.log(event.params.task.end.format("Do MMM  YYYY"));
        console.log(event.params.task.color);



      }
     
    }
    
}
 

</script>
