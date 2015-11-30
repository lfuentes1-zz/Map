$(document).ready(function() {
    "use strict";

    var latitude = 29.423017;
    var longitude = -98.48527;

	// Set our map options
    var mapOptions = {
        // Set the zoom level
        zoom: 11,

        // This sets the center of the map
        center: {
            lat:  latitude,
            lng: longitude
        }
    };

    // Render the map
    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);	

    //Create marker for specified favorite restaurant using the constructor
	var marker = new google.maps.Marker({
		position: {lat: latitude, lng: longitude},
		map: map,
		animation: google.maps.Animation.DROP,
		draggable: true,
		title: "Drag Me!"
	});

    //Determine the Wind Direction
	function windDirection(degrees){

		var localWindDirection = "";

		if ((degrees > 0) && (degrees < 90)) {
			localWindDirection = "NE";
		} else if ((degrees > 90) && (degrees < 180)) {
			localWindDirection = "SE";
		} else if ((degrees > 180) && (degrees < 270)) {
			localWindDirection = "SW";
		} else if ((degrees > 270) && (degrees < 360)) {
			localWindDirection = "NW";
		} else if ((degrees == 0) || (degrees == 360)) {
			localWindDirection = "N";
		} else if (degrees == 90) {
			localWindDirection = "E";
		} else if (degrees == 180) {
			localWindDirection = "S";
		} else if (degrees == 270) {
			localWindDirection = "W";
		}
		
		return (localWindDirection);
	}

	function showWeather (latitude, longitude){
		$.get("http://api.openweathermap.org/data/2.5/forecast/daily?", {
		    APPID: "5fb1bf08fea45a0d1874de805af4110e",
		    lat: latitude,
		    lon: longitude,
		    units: "imperial",
		    cnt: 3
		}).done(function(data){
			// console.log (moment.unix(day.dt).format('ddd, MMM Do');	
			var dailyFacts = "";
			var cityName = data.city.name; //Name of the City

			$("#cityName").html(cityName);
			// console.log (data);	
			data.list.forEach(function (day){
				var theDate = moment.unix(day.dt).format('ddd, MMM Do');	

				var icon = '<img src="http://openweathermap.org/img/w/' + day.weather[0].icon + '.png">'

				dailyFacts += "<tr>" +
					"<td>" + theDate + "</td>" +
					"<td>" + Math.round(day.temp.max) + "&deg; / " + Math.round(day.temp.min) + "&deg" + "</td>" +
					"<td>" + icon + day.weather[0].description + "</td>" + 
					"<td>" + Math.round(day.rain) + "%" + "</td>" +
					"<td>" + windDirection(Math.round(day.deg)) + " " + Math.round(day.speed) + " MPH" + "</td>" +
					"<td>" + Math.round(day.humidity) + "%" + "</td>" + 
					"<tr>";
			});
			$("#populateTable").html(dailyFacts);
		}).fail(function(){
			alert ("Error:  OpenWeatherMap");
		});
	};

	function convertAddressToLatLong (address){
		// Initialize geocoder object
		var geocoder = new google.maps.Geocoder();

		// Geocode our address
		geocoder.geocode({ "address": address }, function(result, status) {
			var localLat = result[0].geometry.location.lat();
			var localLong = result[0].geometry.location.lng();
			var myLatlng = new google.maps.LatLng(localLat,localLong);

		  	// Check for a successful result
		   	if (status == google.maps.GeocoderStatus.OK) {
		    	// Recenter the map over the address
		        map.setCenter(result[0].geometry.location);
		        //drop the pin
		        marker.setPosition(myLatlng);
		        showWeather (localLat, localLong);
	        } else {
		        // Show an error message with the status if our request fails
		        alert("Geocoding was not successful - STATUS: " + status);
		    }
		});
	};

	//Calls the showWeather function 
	showWeather(latitude, longitude);

	//Google Search:  marker drop event in google maps
	google.maps.event.addListener(marker, "dragend", function(event) { 
		// var locallat;
		//var locallong;
        latitude = event.latLng.lat();
        longitude = event.latLng.lng();
        showWeather (latitude, longitude);
    }); 

	$("#search-form").submit(function(event){
		event.preventDefault();
		var address = $("#address").val();
		//convert the address to lat/lon coordiantes
		convertAddressToLatLong (address);	    
	});

});