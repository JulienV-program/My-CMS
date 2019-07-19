<template>
    <div class="page">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <form :action="'/page/' + item.id + '/edit'" method="post">
                            <ckeditor :editor="editor" :config="editorConfig" v-model="item.PageName"></ckeditor>
                            <div v-for="elem in item.Paragraph">
                                <ckeditor :editor="editor" :config="editorConfig" v-model="elem.Body"></ckeditor>

                            </div>
                            <button type="submit"> Enregistrer</button>
                        </form>

                    </div>
                </div>
            </div>
        </section>


        <div class="col-sm-12 col-md-12 col-lg-4 mb-4 ">
            <div id="carouselExampleIndicators" v-for="elem in item.Carrousel" class="carousel slide dog-carousel-inner" data-ride="carousel">
                <ol class="carousel-indicators">

                    <li v-for="(image, index) in elem.images" data-target="#carousel" data-slide-to="0"  class="item-active" ></li>

                </ol>

                <div class="carousel-inner">

                    <div v-for="(image, index) in elem.images" class="carousel-item" :class="{ active: index==0 }" >
                        <div class="dog-slider-item" v-bind:style='"background-image : url(" + image.path + ")"'>
                        </div>
                    </div>

                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import InlineEditor from '@ckeditor/ckeditor5-build-inline';

    export default {
        name: "Page",
        data: function () {
            return {
                item: this.$root.page,
                editor: InlineEditor,
                editorConfig: {
                    toolbar: [ "Bold", "Italic", "Underline", "TextColor", "Font", "FontSize" ]
                }

            }
        }
    }
</script>

<style scoped>

</style>