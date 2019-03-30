<template>
<div>
    
    <button class="bg-blue text-normal btn rounded-lg text-white hover:bg-blue-darker" @click="showModal">
         Edit
        <i class="fas fa-user-edit text-normal text-white ml-2"></i>
    </button>


    <!-- modal -->
    <modal adaptive name="editUserModal" height="auto">

        <edit-user-form :user="user" :logged="logged"></edit-user-form>
            
    </modal>
   
</div>

</template>


<script>

import EditUserForm from '../../forms/EditUserForm.vue';

export default {

  components: { EditUserForm },
  props: ['user', 'logged'],

  methods: {
    showModal() {
      this.$modal.show('editUserModal');
    },
  }
    
}
 

</script>
