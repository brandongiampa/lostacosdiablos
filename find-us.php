<?php
  $page_hero_image = "findus2";
  $page_header = "Find Us";
  include_once 'inc/header.php';?>
        <!--<p>Being a business on wheels, we take advantage of the situation and try to get some quality time on the beach. Our schedule is as follows:</p>
      --></div>
      <div id="map" style="width:100%;height:400px;"></div>
    </main>
    <script>

    function getMapCenter(objArr){
      let locations = objArr.map((obj)=>{
        return obj.location
      })
      let latitudes = locations.map((location)=>{
        return location.lat
      })
      let longitudes = locations.map((location)=>{
        return location.lng
      })
      let latMin = Math.min.apply(null, latitudes)
      let lngMin = Math.min.apply(null, longitudes)
      let latMax = Math.max.apply(null, latitudes)
      let lngMax = Math.max.apply(null, longitudes)
      let latDifference = latMax - latMin
      let lngDifference = lngMax - lngMin
      let centerLat = latMin + (latDifference/2)
      let centerLng = lngMin + (lngDifference/2)

      return {lat: centerLat, lng: centerLng}
    }
    function initMap() {
      var pikeOutlets = {
        location: {lat: 33.770210, lng: -118.192981},
        content: '<h6 style="color:black; font-size:20px; margin:8px auto;">The Pike Outlets</h6><div class="location-hours" style="color:black; font-size:14px;">Monday-Thursday 10am-2pm<br>Friday-Saturday 10am-3pm<br>Sunday 11am-2pm<br> </div><div class="info-window-address" style="color:black; font-size:14px; margin-top:4px;">95 S Pine Ave</br>Long Beach, CA  90802</div>'
      }
      var zoeterPlace = {
        location: {lat: 33.750476, lng: -118.100627},
        content: '<h6 style="color:black; font-size:20px; margin:8px auto;">Zoeter Place</h6><div class="location-hours" style="color:black; font-size:14px;">Monday-Thursday 3pm-7pm<br>Friday-Saturday 4pm-8pm<br>Sunday 3pm-6pm<br> </div><div class="info-window-address" style="color:black; font-size:14px; margin-top:4px;">1190 CA-1</br>Seal Beach, CA  90740</div>'
      }
      var seacliffVillage = {
        location: {lat: 33.686361, lng: -118.003639},
        content: '<h6 style="color:black; font-size:20px; margin:8px auto;">Seacliff Village Shopping Center</h6><div class="location-hours" style="color:black; font-size:14px;">Monday-Thursday 8pm-12am<br>Friday-Saturday 9pm-1am<br>Sunday ---<br> </div><div class="info-window-address" style="color:black; font-size:14px; margin-top:4px;">Yorktown St & Main St.</br>Huntington Beach, CA  92648</div>'
      }
      var destinations = [pikeOutlets, zoeterPlace, seacliffVillage]

      var map = new google.maps.Map(
        document.getElementById('map'), {zoom: 10, center: getMapCenter(destinations)}
      )
      var infoWindow = new google.maps.InfoWindow({content: ""})

      destinations.forEach((destination)=>{
        let marker = new google.maps.Marker({position: destination.location, map: map, icon:"http://192.168.1.232:8080/lostacosamigos/img/logo/marker.png"})
        marker.addListener('click', ()=>{
          infoWindow.setContent(destination.content)
          infoWindow.open(map, marker)
        })
      })
    }
    const googleMapsScript = document.createElement("script")
    googleMapsScript.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDHlWylCMw9F4tCNyrld-seDWF3NEg4vao&callback=initMap'
    document.head.appendChild(googleMapsScript)
    </script>
<?php include_once 'inc/footer.php';?>