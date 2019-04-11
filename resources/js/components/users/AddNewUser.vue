<template>
<div>
    
    <button class=" bg-blue ml-auto text-normal btn rounded-lg text-white hover:bg-blue-dark" @click="showModal"> New User</button>


    <!-- modal -->
    <modal :adaptive="true" name="addUserModal" height="auto">
        <add-user-form></add-user-form>
    </modal>
   
</div>

</template>


<script>

import AddUserForm from '../../forms/AddUserForm.vue';

export default {
  components: { AddUserForm },
  methods: {
    showModal() {
      this.$modal.show('addUserModal');
    },
  }
    
}
 

</script>
