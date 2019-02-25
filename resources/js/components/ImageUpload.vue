<template>
    <div>
        <label class="mt-3 no-underline text-blue text-lg hover:text-blue-darkest rounded-lg py-1 px-2  border border-red">
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

