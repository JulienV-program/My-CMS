<template>
    <div class="puppy">

        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" :url="url + item.Carrousel.id"></vue-dropzone>

        <div v-for="(image, index) in item.Carrousel.images">
                <div class="dog-slider-item" v-bind:style='"background-image : url(" + image.path + ")"'>
                </div>
                <form :action="'live/image/' + image.id + '/edit'" method="post">
                    <textarea   name="content" :editor="editor" :config="editorConfig" :value="image.Description"  ></textarea>

                    <p><input type="submit" value="Submit"></p>
                </form>

            </div>
            <form :action="'live/puppy/' + item.id + '/edit'" method="post">
                <label for="title"> Titre </label>
                <input name="title" id="title" :value="item.Title"></input>
                <label for="body">Description</label>
                <textarea  name="body" id="body" :editor="editor" :config="editorConfig" :value="item.Description"></textarea>
                <p><input type="submit" value="Submit"></p>

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


            }
        }
    }
</script>

<style scoped>

</style>