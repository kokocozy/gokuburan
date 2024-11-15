<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Gokuburan
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map {}
    </style>
</head>

<body>
    <!-- header -->
    <header>
        <nav class="container mx-auto flex items-center px-4 py-2">
            <h1 class="text-xl font-semibold font-sans block">Gokuburan</h1>
        </nav>
    </header>

    <!-- content -->
    <section>
        <div class="container mx-auto flex flex-col items-center justify-center my-4 p-4 gap-4">
            <div class="max-w-xl">
                <p class="text-center">
                    Ayo cari di mana temanmu dikuburkan! Dengan aplikasi ini.
                </p>
            </div>
            <form id="form" data-action="{{ route('search') }}" method="POST">
                @csrf
                <div class="flex gap-4">
                    <input type="text" name="name"
                        class="block w-full rounded-md border-0 py-1.5 pl-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"
                        placeholder="Nama...">
                    <button id="submit" type="submit"
                        class="py-1 px-4 bg-slate-700 text-slate-50 rounded hover:bg-slate-500">Cari</button>
                </div>
            </form>
            <div class="flex flex-col items-center justify-center gap-4">
                <div class="w-[300px] h-[500px] rounded-md shadow bg-slate-700" id="map"></div>
                <div class="mt-8 max-w-xl text-center">
                    <h1 id="name"></h1>
                    <h1 id="graveName"></h1>
                    <a id="buttonGrave" href="#" target="_blank"
                        class="py-1 px-4 bg-slate-700 text-slate-50 rounded hover:bg-slate-500">Google Maps</a>
                </div>
            </div>
        </div>

    </section>
</body>

<script>
    $(document).ready(function () {
        var map;

        var form = '#form';

        $(form).on('submit', function (event) {
            event.preventDefault();

            var url = $(this).attr('data-action');

            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    $(form).trigger("reset");
                    console.log("response", response);

                    if (map != undefined) {
                        map.off();
                        map.remove();
                    }

                    map = L.map('map', {
                        crs: L.CRS.Simple,
                    });

                    const bounds = [[0, 0], [800, 800]];
                    const imageurl = '{{ url('') }}' + '/storage/' + response.data.grave.grave_layout;
                    const image = L.imageOverlay(imageurl, bounds).addTo(map);
                    map.fitBounds(bounds);

                    const cemeteryIcon = L.icon({
                        iconUrl: '/assets/image/cemetery.jpg',
                        iconSize: [40, 40],
                        popupAnchor: [0, -20],
                    });

                    const coordinate = [response.data.lat, response.data.lng];
                    new L.marker(coordinate, { icon: cemeteryIcon })
                        .addTo(map)
                        .bindPopup(`<b>${response.data.name}</b><br />RIP`);

                    document.getElementById("name").innerText = response.data.name;
                    document.getElementById("graveName").innerText = response.data.grave.name;
                    document.getElementById("buttonGrave").href = response.data.grave.gmaps_url;
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });
    });

</script>

</html>