<template>
  <form class="p-10" @submit.prevent="onSubmit" @keydown="form.errors.clear()">
    <div class="field mb-2">
      <label class="label text-sm mb-1 block" for="title">Name</label>

      <div class="control">
          <input
            type="text"
            class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
            name="name"
            v-model="form.name"
            >
            <span v-if="form.errors.has('name')" class="text-red text-xs" v-text="form.errors.get('name')">
            </span>
      </div>

    </div>

    <div v-if="logged.roles[0].name == 'manager'" class="field mb-2">
      <label class="label text-sm mb-1 block" for="title">Role</label>
      <div class="control">
        <select 
          name="role" 
          class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full" 
          v-model="form.role"
          >
          <option disabled value="">Select user role</option>
          <option>operator</option>
          <option>manager</option>
        </select>
      </div>
      <span v-if="form.errors.has('role')" class="text-red text-xs" v-text="form.errors.get('role')">
      </span>

    </div>

    <div class="field mb-2">
      <label class="label text-sm mb-1 block" for="title">Password</label>

      <div class="control">
        <input
          type="password"
          class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
          name="password"
          v-model="form.password"
          >
          <span v-if="form.errors.has('password')" class="text-red text-xs" v-text="form.errors.get('password')">
          </span>
      </div>

    </div>

    <div class="field mb-4">
      <label class="label text-sm mb-1 block" for="title">Confirm password</label>

      <div class="control">
        <input
          type="password"
          class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
          name="password_confirmation"
          v-model="form.password_confirmation"
          >
          <span v-if="form.errors.has('password')" class="text-red text-xs" v-text="form.errors.get('password')">
          </span>
      </div>

    </div>

    <div class="flex mt-4">
      <div class="ml-auto control flex">
        <button @click.prevent="$modal.hide('editUserModal')" class="btn mr-2 text-grey-darker text-lg hover:border-blue hover:text-blue rounded-lg py-1 px-4 border-1 border-grey">Cancel</button>
        <button 
          type="submit" 
          :class="loading ? 'loader' : ''"
          class="btn py-1 px-4 text-lg button rounded-lg text-white hover:bg-blue-dark" :disabled="form.errors.any()"
          >Save</button>
      </div>
    </div>

  </form>
  
</template>

<script>
  export default {
    props: ['user', 'logged'],

    data(){
      return {
        form : new Form({ name: this.user.name, role: '', password: '', password_confirmation: ''}),
        loading: false
      }
    },

    methods: {
      
      onSubmit() {
        this.loading = true;

        this.form.submit('patch', '/users/' + this.user.id )
        .then((data) => {
          location.reload();
        })
        .catch(errors => {
          this.loading = false;
        });
      }
    }
  }
</script>

