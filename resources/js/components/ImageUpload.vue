<template>
    <div>
        <label class="text-small button text-white is-link hover:bg-blue-dark mt-2">
            Upload photo  
            <input hidden type="file"  accept="image/*" @change="onChange">
        </label>                
    </div>
</template>

<script>
export default {
    methods: {
        onChange(e) {
            if( ! e.target.files.length ) return;

            let file = e.target.files[0];

            let reader = new FileReader();

            reader.readAsDataURL(file);

            reader.onload = e => {
                let src = e.target.result;

                this.$emit('loaded', {src,file});
            }

            
        } 

        
    }
}
</script>

