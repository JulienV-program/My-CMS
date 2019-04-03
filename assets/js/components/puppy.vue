<template>
    <div class="puppy">

        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" :url="url + item.Carrousel.id"></vue-dropzone>

        <div v-for="(image, index) in item.Carrousel.images">
                <div class="dog-slider-item" v-bind:style='"background-image : url(" + image.path + ")"'>
                </div>
                    <ckeditor   :id="'image' + image.id" :editor="editor" :config="editorConfig" :value="image.Description"  @blur="imageBlur(image.id)" ></ckeditor>

            </div>
            <form :action="'live/puppy/' + item.id + '/edit-title'" method="post">
                <label for="title"> Titre </label>
                <input name="title" id="title" :value="item.Title"></input>
                <div>
                    <label for="body">Description</label>
                    <div id="id" style="display: none">{{item.id}}</div>
                    <ckeditor  name="body" id="body" :editor="editor" :config="editorConfig" :value="item.Description" @blur="onEditorBlur"></ckeditor>
                    <p><input type="submit" value="Submit"></p>
                </div>


            </form>


    </div>
</template>

<script>
    import InlineEditor from '@ckeditor/ckeditor5-build-inline';
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        name: "puppy",
        components: {
            vueDropzone: vue2Dropzone
        },
        data: function () {
            return {
                item: this.$root.puppy,
                editor: InlineEditor,
                editorConfig: {
                    toolbar: ["Bold", "Italic", "Underline", "TextColor", "Font", "FontSize"]
                },
                dropzoneOptions: {
                    url: '/uploader/new',
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    headers: { "My-Awesome-Header": "header value" }
                },
                url: '/_uploader/carrousel/upload?id=',

                onEditorBlur: function(){
                    var $data = document.querySelector('#body').innerHTML;
                    var $id = document.querySelector('#id').innerHTML;
                    var formData = new FormData();
                    formData.append('data', $data)

                    fetch('/live/puppy/' + $id + '/edit-description', {
                        method: 'POST',
                        body: formData
                    })
                        .then(function(response){
                            console.log(response)
                        })
                        .catch(function(){
                            alert('Error');
                        })
                },

                imageBlur($id){
                    var $data = document.querySelector('#image' + $id).innerHTML;
                    onImageBlur($data, $id)

                },



            }
        }
    }

    function onImageBlur($data, $id){

        var formData = new FormData();
        formData.append('data', $data)

        fetch('live/image/' + $id + '/edit', {
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
</script>

<style scoped>

</style>