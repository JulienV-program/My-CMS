<template>
    <div class="carrousel">
        <button onclick="location.reload()" click="">Mettre à jour</button>
        <div v-for="carrousel in item.Carrousel">
            <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" :url="url + carrousel.id"></vue-dropzone>
            <a :href="'/uploaderCarrousel/carrousel-' + carrousel.id">Gérer les images</a>

            <div class="row">
                <div class="col-4" v-for="(image, index) in carrousel.images">
                    <div class="dog-slider-item" v-bind:style='"background-image : url(" + image.path + ")"'>
                    </div>


                </div>
            </div>

        </div>


    </div>
</template>

<script>

    import vue2Dropzone from 'vue2-dropzone'

    export default {
        name: "carrousel",
        components: {
            vueDropzone: vue2Dropzone
        },
        data: function(){
            return {
                item: this.$root.page,
                dropzoneOptions: {
                    // url: '/_uploader/carrousel/upload?id=',
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    headers: { "My-Awesome-Header": "header value" }
                },
                url: '/_uploader/carrousel/upload?id=',


            }
        }

    }
</script>

<style scoped>

</style>