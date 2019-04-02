console.log('main.js')

import Vue from 'vue'
import dog from './components/dog'
import paragraph from './components/paragraph'
import puppy from './components/puppy'
import carrousel from './components/carrousel'
import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use( CKEditor);


var $puppy = document.querySelectorAll('.edit-button');




for (var i = 0; i < $puppy.length; i++) {
    var $button = $puppy[i];
    getpuppy($button)
}



function getpuppy($button){

    $button.addEventListener('mousedown', function(event){
        event.preventDefault();
        console.log($button.id);
        $button.style.display = "none";


        fetch('/puppys/' + $button  .title + '/get', {
            method: 'GET'
            // body: new FormData($form)
        })
            .then(function(response){
                console.log(response)
                return response.json()
            })
            .then(function (obj) {
                console.log(obj);
                new Vue({
                    el: '#puppy-' + $button.title,
                    data: {
                        puppy: obj,
                    },
                    template: '<puppy/>',
                    components: {puppy},

                })

                Vue.nextTick(function () {
                    $('textarea.editor').each(function(){
                        CKEDITOR.replace(this.id);
                    });
                });

            })

            .catch(function(){
                alert('Error');
            })
    })

}



var $paragraph = document.querySelectorAll('.edit-paragraph');


for (var i = 0; i < $paragraph.length; i++) {
    var $button = $paragraph[i];
    getparagraph($button)
}

function getparagraph($button){

    $button.addEventListener('mousedown', function(event){
        event.preventDefault();
        console.log($button.id);
        $button.style.display = "none";


        fetch('/paragraph/' + $button.title + '/get', {
            method: 'GET'
            // body: new FormData($form)
        })
            .then(function(response){
                console.log(response)
                return response.json()
            })
            .then(function (obj) {
                console.log(obj);
                new Vue({
                    el: '#paragraph-' + $button.title,
                    data: {
                        paragraph: obj,
                    },
                    template: '<paragraph/>',
                    components: {paragraph},

                })

                Vue.nextTick(function () {
                    $('textarea.editor').each(function(){
                        CKEDITOR.replace(this.id);
                    });
                });

            })

            .catch(function(){
                alert('Error');
            })
    })

}




var $carrousel = document.querySelectorAll('.edit-carrousel');


for (var i = 0; i < $carrousel.length; i++) {
    var $button = $carrousel[i];
    getcarrousel($button)
}

function getcarrousel($button){

    $button.addEventListener('mousedown', function(event){
        event.preventDefault();
        console.log($button.id);
        $button.style.display = "none";


        fetch('/page/' + $button.title + '/get', {
            method: 'GET'
            // body: new FormData($form)
        })
            .then(function(response){
                console.log(response)
                return response.json()
            })
            .then(function (obj) {
                console.log(obj);
                new Vue({
                    el: '#carrousel-' + $button.title,
                    data: {
                        page: obj,
                    },
                    template: '<carrousel/>',
                    components: {carrousel},

                })


            })

            .catch(function(){
                alert('Error');
            })
    })

}


var $dog = document.querySelectorAll('.edit-dog');


for (var i = 0; i < $dog.length; i++) {
    var $button = $dog[i];
    getDog($button)
}

function getDog($button){

    $button.addEventListener('mousedown', function(event){
        event.preventDefault();
        console.log($button.id);
        $button.style.display = "none";


        fetch('/dogs/' + $button.title + '/get', {
            method: 'GET'
            // body: new FormData($form)
        })
            .then(function(response){
                console.log(response)
                return response.json()
            })
            .then(function (obj) {
                console.log(obj);
                new Vue({
                    el: '#dog',
                    data: {
                        dog: obj,
                    },
                    template: '<dog/>',
                    components: {dog},

                })


            })

            .catch(function(){
                alert('Error');
            })
    })

}








