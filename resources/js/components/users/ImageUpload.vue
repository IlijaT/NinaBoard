<template>
    <div>
        <label >
            <div class="flex btn flex mt-2">
                <div>
                    <p @mouseover="mouseOver" @mouseleave="mouseLeave" class="text-white text-normal mb-2">
                        <i class="fas fa-plus-circle text-normal mr-1"></i>
                        Add your photo
                    </p>
                    <p v-show="showText"  class="self-center text-grey-darkest text-xs font-bold -mt-4">     up to 2MB</p>
                </div>

              
            </div>
            <input hidden type="file"  accept="image/*" @change="onChange">
        </label>    
        

    </div>
</template>

<script>
export default {

    data() {
        return {
            showText: false
        }
    },
    methods: {
        mouseOver(){
            this.showText = true;
        },
        mouseLeave(){
            this.showText = false;
        },
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

