// Create the map and tiles
const mymap = L.map('mapid').setView([31.324422, -20.639121], 3);

const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const tiles = L.tileLayer(tileUrl, {attribution});

tiles.addTo(mymap);

// Making a marker with a custom icon
var userIcon = L.icon({
    iconUrl: 'images/user-marker.png',
    shadowUrl: 'images/marker-shadow.png',
    iconSize:     [50, 50],
    shadowSize:   [30, 40],
    shadowAnchor: [10, 16]
});


var latlngs = Array();
var userlatlng = Array();

users.forEach(element => {
    var popup = "User: " + element.user_id;
    console.log(popup);
    L.marker([element.latitude, element.longitude], {icon: userIcon}).addTo(mymap).bindPopup(popup);
    userlatlng.push([element.user_id, element.latitude, element.longitude]);
});


var max = 0;
var weights = Array();
var IPlatlng = Array();

jArray.forEach(element => {
    if (max < element.count){
        max = element.count;
    }

    weights.push(element.count);
    L.marker([element.latitude, element.longitude]).addTo(mymap);
    IPlatlng.push([element.user_id, element.latitude, element.longitude]);
});

for (let i = 0; i < weights.length; i++){
    weights[i] = weights[i]/max;
}

for (let i = 0; i < userlatlng.length; i++){
    for (let j = 0; j < IPlatlng.length; j++){
        if (userlatlng[i][0] == IPlatlng[j][0]){
            latlngs.push([[userlatlng[i][1], userlatlng[i][2]], [IPlatlng[j][1], IPlatlng[j][2]]]);
        }
    }
}

var polyline = L.polyline(latlngs, {weight: 0.2, color: 'black'}).addTo(mymap);