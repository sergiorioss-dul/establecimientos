import { OpenStreetMapProvider } from "leaflet-geosearch";

const lat = document.querySelector('#lat').value === '' ? 19.4978 : document.querySelector('#lat').value;
const lng = document.querySelector('#lng').value === '' ? -99.1269 : document.querySelector('#lng').value;
const map = L.map("map").setView([lat, lng], 15);
let markers = new L.FeatureGroup().addTo(map);
let marker;

document.addEventListener("DOMContentLoaded", () => {
    if (document.querySelector("#map")) {
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        //Buscar direccion
        const buscador = document.querySelector("#formbuscador");
        buscador.addEventListener("blur", buscarDireccion);
    }
});

function llenarInputs(result){
    console.log('here'+result);
    document.querySelector('#direccion').value = result.address.Address || '';
    document.querySelector('#colonia').value = result.address.Neighborhood || '';
    document.querySelector('#lat').value = result.latlng.lat ||'';
    document.querySelector('#lng').value = result.latlng.lng || '';

}

function buscarDireccion(e) {

    if (e.target.value.length > 8) {
        //Si existe un pin anterior limpiarlo
        markers.clearLayers();
        var geocodeService = L.esri.Geocoding.geocodeService();
        const provider = new OpenStreetMapProvider();
        provider.search({ query: e.target.value }).then(res => {
            geocodeService
                .reverse()
                .latlng(res[0].bounds[0], 15)
                .run(function(error, res) {
                    llenarInputs(res);
                });
            //mostar mapa
            map.setView(res[0].bounds[0], 15);
            //agregar el pin
            marker = new L.marker(res[0].bounds[0], {
                draggable: true,
                autoPan: true
            })
                .addTo(map)
                .bindPopup(res[0].label)
                .openPopup();
            //asignar al contenedor
            markers.addLayer(marker);
            marker.on("moveend", function(e) {
                marker = e.target;
                const posicion = marker.getLatLng();
                map.panTo(new L.LatLng(posicion.lat, posicion.lng));
                // reverse geocoding cuando el usuario reubica el ping
            geocodeService
            .reverse()
            .latlng(posicion, 15)
            .run(function (error, result) {
              marker.bindPopup(result.address.LongLabel);
              marker.openPopup();
              llenarInputs(result);
            });
            });
        });
    }
}
