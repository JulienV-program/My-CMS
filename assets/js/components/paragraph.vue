<template>
    <div class="paragraph">
        <div id="id" style="display: none">{{item.id}}</div>

        <ckeditor id="editor" :editor="editor" :config="editorConfig" v-model="item.Body" @blur="onEditorBlur"></ckeditor>
    </div>

</template>

<script>
    import InlineEditor from '@ckeditor/ckeditor5-build-inline'


    export default {
        name: "paragraph",
        data: function () {
            return {
                item: this.$root.paragraph,
                editor: InlineEditor,

                editorConfig: {

                    // plugins: [ Highlight, Underline,Bold, Italic, Underline, Strikethrough, Code, Subscript, Superscript],

                    // toolbar: ['Bold','Italic','Underline','Highlight','bold', 'italic', 'underline', 'strikethrough', 'code','subscript', 'superscript']
                },

                onEditorBlur: function(){
                    var $data = document.querySelector('#editor').innerHTML;
                    var $id = document.querySelector('#id').innerHTML;
                    var formData = new FormData();
                    formData.append('data', $data)

                    fetch('/live/paragraph/' + $id + '/edit', {
                        method: 'POST',
                        body: formData
                    })
                        .then(function(response){
                            location.reload()
                            console.log(response)
                        })
                        .catch(function(){
                            alert('Error');
                        })
                }
            }
        }


    }
</script>

<style scoped>

</style>