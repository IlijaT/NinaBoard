<template>
<div>
    
    <button class=" bg-blue ml-auto text-normal btn rounded-full text-white hover:bg-blue-dark" @click="showModal"> New User</button>


    <!-- modal -->
    <modal adaptive name="addUserModal" :height="490">
        <div class="flex flex-column h-full bg-white p-4">
        
            <h1 class="text-2xl font-normal mb-3 text-center">
                New User
            </h1>

            <add-user-form></add-user-form>
            
        </div>
    </modal>
   
</div>

</template>


<script>

import AddUserForm from '../forms/AddUserForm.vue';

export default {
  components: { AddUserForm },
  methods: {
    showModal() {
      this.$modal.show('addUserModal');
    },
  }
    
}
 

</script>
