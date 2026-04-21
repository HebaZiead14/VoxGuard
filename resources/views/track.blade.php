<!DOCTYPE html>
<html>
<head>
    <title>VoxGuard - Live Tracking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 100vh; width: 100%; }
        .info-box { position: absolute; top: 10px; left: 10px; z-index: 1000; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.3); }
    </style>
</head>
<body>

<div class="info-box">
    <strong>تتبع حالة: {{ $sos->user->first_name }}</strong><br>
    الحالة: <span id="status">{{ $sos->status }}</span>
</div>

<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // إعداد الخريطة
    var map = L.map('map').setView([{{ $sos->latitude }}, {{ $sos->longitude }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // إضافة علامة الموقع (Marker)
    var marker = L.marker([{{ $sos->latitude }}, {{ $sos->longitude }}]).addTo(map)
        .bindPopup('الموقع الحالي للمستغيثة').openPopup();

    // دالة لتحديث الموقع من الـ API كل 10 ثواني
    function updateLocation() {
        fetch('/api/sos/status/{{ $sos->id }}') // سنحتاج لعمل Route بسيط يرجع JSON
            .then(response => response.json())
            .then(data => {
                var newLatLng = new L.LatLng(data.latitude, data.longitude);
                marker.setLatLng(newLatLng);
                map.panTo(newLatLng);
                document.getElementById('status').innerText = data.status;
            });
    }

    setInterval(updateLocation, 10000); // تحديث كل 10 ثواني
</script>
</body>
</html>