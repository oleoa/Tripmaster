<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div id="map" class="rounded z-30 min-h-full h-96"></div>

<script>

  var map = L.map('map').setView([{{$lat}}, {{$lon}}], 13);

  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  var marker = L.marker([{{$lat ? $lat : 51.505}}, {{$lon ? $lon : -0.09}}]).addTo(map);

  @if($editable)
    map.on('click', function(e) {
      marker.setLatLng(e.latlng);
      document.querySelector('input[name="lat"]').value = e.latlng.lat;
      document.querySelector('input[name="lon"]').value = e.latlng.lng;
    });
  @endif


</script>
