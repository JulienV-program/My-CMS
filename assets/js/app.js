

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');


$thumbnail = document.querySelector("#thumbnail");



$fullSize = document.querySelector("#fullSize");


function show($title){
    console.log($title)

    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function(){ $fullSize.innerHTML = '<div id="close" onclick="hide()">Close</div>' +  ajax.response
        $fullSize.style.display = 'block'}

    ajax.open("GET", "/fullsize/?title="+ $title , true )
    ajax.send();

}

function hide(){
    $fullSize.innerHTML = "";
    $fullSize.style.display = "none";
}

console.log('test')