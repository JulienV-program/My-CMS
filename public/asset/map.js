var mymap = L.map('mapid').setView([45.669005, 2.878375], 10);

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
}).addTo(mymap);

var marker = L.marker([45.666163, 2.870505]).addTo(mymap);
marker.bindPopup("<b>Bois des Volcans</b>").openPopup();
