<template>
    <div>
        <img class="rounded-full h-32 w-32 flex items-center justify-center" 
            :src="avatar" 
            >

        <form method="post" enctype="multipart/form-data">
            <image-upload name="avatar" @loaded="onLoad"></image-upload>
        </form>  
    </div>
</template>

<script>
import ImageUpload from './ImageUpload.vue';
export default {
    components: { ImageUpload },
    props: ['user'],

    data() {
        return {
            'avatar' : this.user.avatar_path
        }
    },

    methods: {
        onLoad(avatar) {
            
            this.avatar = avatar.src;

            // persist to the server
    
            this.persist(avatar.file);
        },

        persist(avatar) {
            let data = new FormData();
            data.append('avatar', avatar);

            axios.post(`/users/${this.user.id}/avatar`, data)
                .then(() => flash('Avatar uploaded'));
        }

         
    }

}
</script>

