<template>
<div>
    
    <button class="bg-grey text-normal btn rounded-full text-white hover:bg-grey-darker" @click="showModal">
         Edit
        <i class="fas fa-user-edit text-lg text-white ml-2"></i>
    </button>


    <!-- modal -->
    <modal adaptive name="editUserModal" :height="420">
        <div class="flex flex-column h-full bg-white p-4">
        
            <h1 class="text-2xl font-normal mb-3 text-center">
                Change details
            </h1>

            <edit-user-form :user="user"></edit-user-form>
            
        </div>
    </modal>
   
</div>

</template>


<script>

import EditUserForm from '../forms/EditUserForm.vue';

export default {

  components: { EditUserForm },
  props: ['user'],
  methods: {
    showModal() {
      this.$modal.show('editUserModal');
    },
  }
    
}
 

</script>
