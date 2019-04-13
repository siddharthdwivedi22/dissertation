<!DOCTYPE html>
<html>
<head>
    <title>Place Autocomplete Address Form</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        html, body, #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px
        }
        #map-canvas { width: 600px; height: 400px; }
        #locationField, #controls {
            position: relative;
            width: 480px;
        }
        #autocomplete {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 99%;
        }
        .label {
            text-align: right;
            font-weight: bold;
            width: 100px;
            color: #303030;
        }
        #address {
            border: 1px solid #000090;
            background-color: #f0f0ff;
            width: 480px;
            padding-right: 2px;
        }
        #address td {
            font-size: 10pt;
        }
        .field {
            width: 99%;
        }
        .slimField {
            width: 80px;
        }
        .wideField {
            width: 200px;
        }
        #locationField {
            height: 20px;
            margin-bottom: 2px;
        }
    </style>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAx_ZYuivsfVrnyEDZ4XCG1hVedQBvCHmk&libraries=places"></script>
    <script>
        // This example displays an address form, using the autocomplete feature
        // of the Google Places API to help users fill in the information.

        var placeSearch, autocomplete;
        var componentForm = {
            street_number: 'short_name',
            street_address: 'long_name',
            neighborhood: 'long_name',
            route: 'long_name',
            locality: 'long_name',
            country: 'long_name',
            postal_code: 'short_name'
        };

        function initialize() {
            var mapOptions = {
                center: new google.maps.LatLng(51.481383, -0.109863),
                zoom: 10
            };
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')), {types: ['geocode']});
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                // Get the place details from the autocomplete object.
                var place = autocomplete.getPlace();

                for (var component in componentForm) {
                    document.getElementById(component).value = '';
                    document.getElementById(component).disabled = false;
                }
                var newPos = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                map.setOptions({
                    center: newPos,
                    zoom: 15
                });
                //add a marker
                var marker = new google.maps.Marker({
                    position: newPos,
                    map: map,
                    title: "New marker"
                });

                // Get each component of the address from the place details
                // and fill the corresponding field on the form.
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType]) {
                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById(addressType).value = val;
                    }
                }
            });
        }

    </script>
</head>
<body onload="initialize()">
<div id="locationField">
    <input id="autocomplete" placeholder="Enter your address"
           onFocus="geolocate()" type="text"/>
</div>

<table id="address">
    <tr>
        <td class="label">Street address</td>
        <td class="slimField"><input class="field" id="street_number" disabled="true"/></td>
        <td class="wideField" colspan="2"><input class="field" id="route" disabled="true"/></td>
    </tr>

    <tr>
        <td class="label">Street address</td>
        <td class="slimField"><input class="field" id="street_address" disabled="true"/></td>
    </tr>

    <tr>
        <td class="label">Neighbourhood</td>
        <td class="slimField"><input class="field" id="neighborhood" disabled="true"/></td>
    </tr>

    <tr>
        <td class="label">City</td>
        <td class="wideField" colspan="3"><input class="field" id="locality"
                                                 disabled="true"/></td>
    </tr>
    <tr>

        <td class="label">Zip code</td>
        <td class="wideField"><input class="field" id="postal_code"
                                     disabled="true"/></td>
    </tr>
    <tr>
        <td class="label">Country</td>
        <td class="wideField" colspan="3"><input class="field"
                                                 id="country" disabled="true"/></td>
    </tr>
</table>

<div id="map-canvas"></div>
</body>
</html>