<template>
    <div class="dog">
        <div id="id" style="display: none">{{item.id}}</div>
        <button onclick="location.reload()">Enregistrer les modification</button>
        <div class="col-sm-12 col-md-12 col-lg-8 mb-4"><ckeditor id="editor-1" :editor="editor" v-model="item.Name" @blur="onEditorBlur1"></ckeditor></div>
        <div class="col-sm-12 col-md-12 col-lg-8 mb-4"><ckeditor id="editor-2" :editor="editor" v-model="item.Description" @blur="onEditorBlur2"></ckeditor></div>

            <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" :url="url + item.Carrousel.id"></vue-dropzone>
            <a :href="'/uploaderCarrousel/carrousel-' + item.Carrousel.id">Gérer les images</a>

            <div class="row">
                <div class="col-4" v-for="(image, index) in item.Carrousel.images">
                    <div class="dog-slider-item" v-bind:style='"background-image : url(" + image.path + ")"'>
                    </div>


                </div>
            </div>




        </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'

    import InlineEditor from '@ckeditor/ckeditor5-build-inline';



    export default {
        name: "dog",
        components: {
            vueDropzone: vue2Dropzone
        },
        data: function () {
            return {
                item: this.$root.dog,
                editor: InlineEditor,
                dropzoneOptions: {
                    url: '/uploader/new',
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    headers: { "My-Awesome-Header": "header value" }
                },
                url: '/_uploader/carrousel/upload?id=',

                onEditorBlur1: function(){
                    var $data = document.querySelector('#editor-1').innerHTML;
                    var $id = document.querySelector('#id').innerHTML;
                    var $route = '/live/dog/' + $id + '/edit-name'
                    onEditorBlur($data, $route)
                },
                onEditorBlur2: function(){
                    var $data = document.querySelector('#editor-2').innerHTML;
                    var $id = document.querySelector('#id').innerHTML;
                    var $route = '/live/dog/' + $id + '/edit-description'
                    onEditorBlur($data, $route)
                },


            }

            }

    }

    function onEditorBlur($data, $route){
        var formData = new FormData();
        console.log($route)
        formData.append('data', $data)

        fetch($route, {
            method: 'POST',
            body: formData
        })
            .then(function(response){
                console.log(response)

            })
            .catch(function(){
                alert('Error');
            })
    }

    function save() {
        location.reload();
    }

</script>

<style scoped>

</style>