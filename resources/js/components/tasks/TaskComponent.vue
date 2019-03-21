<template>
  <div>
    <div class="flex">
      {{ taskInComponent.title }}
    </div>
            <!-- <form method="POST" action="{{ $task->path() }}">
          @method('PATCH')
          @csrf
          <div class="flex">
              <input class="w-full {{ $task->completed ? 'text-grey' : ''}}" name="title" type="text" value="{{ $task->title }}">
              <input type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
          </div>
      </form> -->
    
  </div>

</template>


<script>


export default {
    props: ['task'],

    created() {
      this.taskInComponent = this.task;
    },

    data() {
      return {
        taskInComponent: ''
      }
    },
    
}
 
</script>
