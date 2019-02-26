<template>
    <div>
        <label >
            <div class="flex btn flex mt-2">
                 <div>
                     <p class="rounded-full h-8 w-8 text-grey-darker mr-2 bg-white text-xl font-bold  hover:bg-blue-dark hover:text-purple-darkest">+</p>
                 </div>
                <div>
                    <p @mouseover="mouseOver" @mouseleave="mouseLeave" class="text-white text-normal p-1 mb-0">Add your photo</p>
                    <p v-show="showText"  class="text-purple-darkest text-xs font-bold -mt-2">Add up to 2MB</p>
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

