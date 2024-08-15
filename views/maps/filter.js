import 'leaflet'
import 'leaflet-search';
import 'leaflet-search/dist/leaflet-search.css';

export function createFilter(map, layer){
        const searchControl = new L.Control.Search({
            layer: layer,        // The layer with searchable items
            initial: false,
            collapsed: false,
            zoom: 10,
            position: 'topright',
            textPlaceholder: 'Search for offers or requests',
            marker: false,        // Whether to show a marker when an item is found
        });
        map.addControl(searchControl);
        return searchControl;
}


/*
*
var searchLayer = L.layerGroup().addTo(map);
//... adding data in searchLayer ...
map.addControl( new L.Control.Search({layer: searchLayer}) );
//searchLayer is a L.LayerGroup contains searched markers

*
*
*  let controlSearch = new L.Control.Search({
        position: "topright", layer:markerLayerGroup,
        initial: false, zoom: 15,
        marker: false
        });
        map.addControl(controlSearch);
* */