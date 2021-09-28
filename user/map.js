$(document).ready(function () {

    // Create the map and tiles
    var map = L.map('mapid').setView([31.324422, -33.639121], 3);

    var attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    var tileURL = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
    var tiles = L.tileLayer(tileURL, {attribution});

    tiles.addTo(map); 

    // Heatmaps
    var options = {
        radius: 30,
        gradient: {0.4: 'green', 0.65: 'blue', 1: 'red'},
        minOpacity: 0.1,
        maxOpacity: 0.8
    }

    jArray.forEach(element => {
        L.heatLayer([[element.latitude, element.longitude, element.count]], options).addTo(map);
    });
});