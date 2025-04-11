/**
 * vars
 */
var userLat,
    userLng,
    locationPins = [],
    locationData,
    map;

(function ($) {

    $('#loading-animation').fadeIn();

    /**
     * Get dealer zip values if a sessionStorage item doesn't already exist
     */
    if (sessionStorage.getItem('locationData') !== null) {

        locationData = JSON.parse(sessionStorage.getItem('locationData'));

        /**
         * If the map-canvas element exists, run initialization functions.
         * These functions should not be run in global scope, else JS errors start accruing.
         */
        if (document.getElementById('map-container')) {

            /**
             * Initialize Google Map.
             */
            $(document).ready(function () {
                google.maps.event.addDomListener(window, 'load', initMap);
            });

        }

    } else {

        fireAjaxRequest(function () {
            locationData = JSON.parse(sessionStorage.getItem('locationData'));

            /**
             * If the map-canvas element exists, run initialization functions.
             * These functions should not be run in global scope, else JS errors start accruing.
             */
            if (document.getElementById('map-container')) {

                /**
                 * Initialize Google Map.
                 */
                initMap();

            }
        });
    }

    function fireAjaxRequest(callback) {

        var endPoint = '/wp-json/wp/v2/bus_stop',
            locationArray = [];

        $.ajax({
            url: endPoint,
            type: "GET",
            data: {
                "per_page": "100",
                "orderby": "title",
                "order": "asc"
            },
        })
            .done(function (data, textStatus, jqXHR) {
                var totalPages = parseInt(jqXHR.getResponseHeader('X-WP-TotalPages'));

                /**
                 * push returned values to array
                 */
                $.each(data, function () {
                    locationArray.push(this);
                });

                /**
                 * check if we've got all post values. if not, run more ajax requests
                 */
                if (totalPages > 1) {
                    var i;
                    for (i = 2; i <= totalPages; i++) {
                        $.ajax({
                            url: endPoint,
                            type: "GET",
                            data: {
                                "per_page": "100",
                                "page": i,
                                "orderby": "title",
                                "order": "asc"
                            },
                        })
                            .done(function (data, textStatus, jqXHR) {
                                $.when(
                                    $.each(data, function () {
                                        locationArray.push(this);
                                    })
                                ).then(function () {
                                    sessionStorage.setItem('locationData', JSON.stringify(locationArray));
                                    callback();
                                });
                            });

                    }
                } else {
                    sessionStorage.setItem('locationData', JSON.stringify(locationArray));
                    callback();
                }

            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("HTTP Request Failed");
            })
            .always(function () {
                /* ... */
            });

    }

    /**
     * Map initialization function.
     */
    function initMap() {

        /**
         * @todo need to figure this out w/o geolocation
         * If userLat/userLng aren't set it defaults to Minneapolis Lat/Lng
         */
        // if ( userLat === '' ) {
        userLat = '44.986656';
        // }
        // if ( userLng === '' ) {
        userLng = '-93.258133';
        // }

        var mapOptions = {
            center: {
                lat: parseFloat(userLat),
                lng: parseFloat(userLng)
            },
            scrollwheel: false,
            mapTypeControl: false,
            streetViewControl: false,
            zoom: 7
        };

        map = new google.maps.Map(document.getElementById('map-container'), mapOptions);

        /**
         * Set the map marker pins if we have locationPins available.
         */
        setMarkers(map, locationData);

        $('#loading-animation').fadeOut();

    }

    /**
     * Set markers on the map function.
     *
     * @param map
     * @param locationData
     */
    function setMarkers(map, locationData) {

        if (locationData === null) {
            locationData = JSON.parse(sessionStorage.getItem('locationData'));
        }

        clearMarkers();

        $.when(
            $.each(locationData, function () {

                // Add Markers to Map
                var marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(this['acf']['location_map']['lat']),
                        lng: parseFloat(this['acf']['location_map']['lng'])
                    },
                    map: map,
                    title: this['title']['rendered'],
                    lat: this['acf']['location_map']['lat'],
                    lng: this['acf']['location_map']['lng'],
                    address: this['acf']['address'],
                    city: this['acf']['city'],
                    state: this['acf']['state'],
                    zip: this['acf']['zip_code']
                });

                locationPins.push(marker);

                var infowindow = new google.maps.InfoWindow();

                google.maps.event.addListener(marker, 'click', function () {

                    infowindow.setContent(
                        '<div class="map-info-wrap">' +
                        '<div class="map-info-title">' + this.title + '</div>' +
                        '<div class="map-info-address"><p>' + this.address + '<br>' + this.city + ', ' + this.state + ' ' + this.zip + '</p></div>' +
                        '<div class="map-directions"><a href="https://www.google.com/maps/dir/?api=1&destination=' + this.lat + ',' + this.lng + '" target="_blank">Get Directions <i class="fa fa-chevron-circle-right"></i></a></div>' +
                        '</div>'
                    );

                    infowindow.open(map, this);

                });
            })
        ).then(function () {
            setMapBoundaries();
            printLocationMarkup(locationData);
        });

    }

    /**
     *  Set map boundaries to contain all pins
     */
    function setMapBoundaries() {
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0; i < locationPins.length; i++) {
            bounds.extend(locationPins[i].getPosition());
        }
        map.fitBounds(bounds);
        if (locationPins.length <= 1) {
            var listener = google.maps.event.addListener(map, 'idle', function () {
                if (map.getZoom() > 11) {
                    map.setZoom(11);
                }
                google.maps.event.removeListener(listener);
            });
        }
    }

    /**
     * Function to clear all the markers on the map
     */
    function clearMarkers() {

        for (var i = 0; i < locationPins.length; i++) {
            locationPins[i].setMap(null);
        }
        locationPins = [];

    }

    /**
     * Convert radians to degrees
     */
    function rad2deg(angle) {
        return angle * (180 / Math.PI);
    }

    /**
     * Convert degrees to radians
     */
    function deg2rad(angle) {
        return angle * (Math.PI / 180);
    }

    /**
     * Get distance.
     *
     * @param {number} $lat1 Latitude one for distance calculation.
     * @param {number} $lon1 Longitude one for distance calculation.
     * @param {number} $lat2 Latitude two for distance calculation.
     * @param {number} $lon2 Longitude two for distance calculation.
     *
     * @return {number} $miles distance value in Miles
     */
    function get_distance($lat1, $lon1, $lat2, $lon2) {

        var $theta,
            $dist,
            $miles;

        $theta = $lon1 - $lon2;

        $dist = Math.sin(deg2rad($lat1)) * Math.sin(deg2rad($lat2)) + Math.cos(deg2rad($lat1)) * Math.cos(deg2rad($lat2)) * Math.cos(deg2rad($theta));

        $dist = Math.acos($dist);

        $dist = rad2deg($dist);

        $miles = $dist * 60 * 1.1515;

        return $miles;

    }

    /**
     * Dynamic sorting function
     *
     * @param key
     * @returns {Function}
     */
    function compareValues(key) {
        return function (a, b) {
            if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
                // property doesn't exist on either object
                return 0;
            }

            const varA = (typeof a[key] === 'string') ?
                a[key].toUpperCase() : a[key];
            const varB = (typeof b[key] === 'string') ?
                b[key].toUpperCase() : b[key];

            var comparison = 0;
            if (varA > varB) {
                comparison = 1;
            } else if (varA < varB) {
                comparison = -1;
            }
            return comparison;
        };
    }

    /**
     * Find Bus Stops w/in 100 miles of searched zip code
     *
     * @param {number} searchZip
     * @param {array} locationData
     */
    function calcResultsByDistance(searchZip, locationData) {
        var zipSearchEndpoint = 'https://maps.googleapis.com/maps/api/geocode/json?address=' + searchZip + '&sensor=false&key=AIzaSyAUgDdE1RH1m9oKT-X8CGFxvoxrLnY_58A',
            resultsByDistance = [],
            searchLat,
            searchLng,
            distance,
            distanceRounded;

        $.ajax({
            url: zipSearchEndpoint,
            beforeSend: function () {
                // loading gif while search function is being run
                $('#loading-animation').fadeIn();
            },
            complete: function () {
                // stop the loading gif
                $('#loading-animation').fadeOut();
            },
            type: "GET",
        })
            .done(function (data, textStatus, jqXHR) {
                searchLat = data['results'][0]['geometry']['location']['lat'];
                searchLng = data['results'][0]['geometry']['location']['lng'];

                $.when(
                    $.each(locationData, function () {
                        distance = get_distance(searchLat, searchLng, this['acf']['location_map']['lat'], this['acf']['location_map']['lng']);
                        distanceRounded = Math.round(distance * 10) / 10;
                        if (distance < 50) {
                            this['distance'] = distanceRounded;
                            resultsByDistance.push(this);
                        } else {
                            return;
                        }
                    })
                ).then(function () {
                    resultsByDistance.sort(compareValues('distance'));
                    setMarkers(map, resultsByDistance);
                });
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("HTTP Request Failed");
            })
            .always(function () {
                /* ... */
            });
    }

    /**
     * State search map filter
     */
    function stateSearch(state) {

        var endPointUrl = '/wp-json/wp/v2/bus_stop',
            stateId = state,
            stateArray = [];

        jQuery.ajax({
            url: endPointUrl,
            beforeSend: function () {
                // loading gif while search function is being run
                $('#loading-animation').fadeIn();
            },
            complete: function () {
                // stop the loading gif
                $('#loading-animation').fadeOut();
            },
            type: "GET",
            data: {
                "per_page": "100",
                "state": stateId,
                "orderby": "title",
                "order": "asc"
            }
        })
            .done(function (data, textStatus, jqXHR) {
                var totalPages = parseInt(jqXHR.getResponseHeader('X-WP-TotalPages'));

                $.each(data, function () {
                    stateArray.push(this);
                });

                /**
                 * check if we've got all post values. if not, run more ajax requests
                 */
                if (totalPages > 1) {
                    var i;
                    for (i = 2; i <= totalPages; i++) {
                        $.ajax({
                            url: endPoint,
                            type: "GET",
                            data: {
                                "per_page": "100",
                                "page": i,
                                "orderby": "title",
                                "order": "asc"
                            },
                        })
                            .done(function (data, textStatus, jqXHR) {
                                $.when(
                                    $.each(data, function () {
                                        stateArray.push(this);
                                    })
                                ).then(function () {
                                    setMarkers(map, stateArray);
                                });
                            });

                    }
                } else {
                    setMarkers(map, stateArray);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("HTTP Request Failed");
            })
            .always(function () {
                /* ... */
            });

    }

    /**
     * Output Location Data Markup
     *
     * @param {array} locationData - array of location object data
     */
    function printLocationMarkup(locationData) {
        var locationContainer = $('.location-results'),
            locationMarkup = '';

        /**
         * Clear any html that's already there
         */
        locationContainer.html();

        $.when(
            $.each(locationData, function () {
                locationMarkup = locationMarkup + '<div class="location-col">';
                locationMarkup = locationMarkup + '<h2>' + this['title']['rendered'] + '</h2>';
                if (typeof this['distance'] !== 'undefined') {
                    locationMarkup = locationMarkup + '<p>Distance: ' + this['distance'] + ' miles</p>';
                }
                locationMarkup = locationMarkup + '<h3>' + this['acf']['address'] + '<br>';
                locationMarkup = locationMarkup + this['acf']['city'] + ', ' + this['acf']['state'] + ' ' + this['acf']['zip_code'] + '</h3>';
                locationMarkup = locationMarkup + '<a href="https://www.google.com/maps/dir/?api=1&destination=' + this['acf']['location_map']['lat'] + ',' + this['acf']['location_map']['lng'] + '" target="_blank">Get Directions</a>';
                locationMarkup = locationMarkup + '</div>';
            })
        ).then(function () {
            locationContainer.html(locationMarkup);
        });

    }

    /**
     * Validate Zip Code Format(s)
     */
    function validateUsZip(zip) {
        var re = /(^\d{5}$)|(^\d{5}-\d{4}$)/;
        return re.test(zip);
    }

    /**
     * Zip Code search
     */
    $('.zip-search form').submit(function(e) {
        e.preventDefault();

        var zipValue = $('input[name="zip"]').val(),
            stateSelect = $('select#state');

        if (!validateUsZip(zipValue)) {
            alert('Please enter a valid Zip Code');
        } else {
            calcResultsByDistance(zipValue, locationData);

            if (stateSelect.val() !== null) {
                stateSelect.val('all');
            }
        }

    });

    /**
     * Kickoff functions when state select field changes
     */
    $('.search-container select').change(function () {
        var stateId = this.value;
        if (stateId !== 'all') {
            stateSearch(stateId);
        } else {
            setMarkers(map, locationData);
        }
        $('input#zip').val('');
    });

})(jQuery);
