<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="formInput">
        <div wire:ignore id="map"></div>
    </div>

    @script
    <script>
        Alpine.data('formInput', () => ({
            state: $wire.$entangle('data.coordinates', true),
            imgurl: '{{ $getImageUrl() }}',
            map: null,
            currentMarker: null,
            dataMarker: JSON.parse('{{ json_encode($getCoordinates()) }}'),
            init() {
                const changeState = (data) => {
                    this.state = data;
                };

                Livewire.on('change-map-leaflet', (imgurl) => {
                    this.imgurl = imgurl;
                    this.reinitializeMap(changeState);
                });

                this.reinitializeMap(changeState);
            },

            reinitializeMap(changeState) {
                if (this.map) {
                    this.map.off();
                    this.map.remove();
                }

                this.map = L.map('map', {
                    crs: L.CRS.Simple,
                });
                const bounds = [[0, 0], [800, 800]];
                const imageurl = '{{ url('') }}' + '/storage/' + this.imgurl;

                const image = L.imageOverlay(imageurl, bounds).addTo(this.map);
                this.map.fitBounds(bounds);

                const cemeteryIcon = L.icon({
                    iconUrl: '/assets/image/cemetery.jpg',
                    iconSize: [40, 40],
                    popupAnchor: [-3, -76],
                });

                if (this.dataMarker.length > 0) {
                    this.currentMarker = new L.marker(this.dataMarker[0], { icon: cemeteryIcon }).addTo(this.map);
                }

                this.map.on('click', (e) => {
                    if (this.currentMarker) {
                        this.map.removeLayer(this.currentMarker);
                    }

                    changeState({
                        latitude: e.latlng.lat,
                        longitude: e.latlng.lng
                    });

                    this.currentMarker = new L.marker(e.latlng, { icon: cemeteryIcon }).addTo(this.map);
                });
            }
        }));
    </script>
    @endscript
</x-dynamic-component>