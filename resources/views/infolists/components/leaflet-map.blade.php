<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div x-data="initMap">
        <div wire:ignore id="map"></div>
    </div>

    @script
    <script>
        Alpine.data('initMap', () => ({
            state: $wire.$entangle('data.coordinates', true),
            imgurl: '{{ $getImageUrl() }}',
            map: null,
            dataMarker: JSON.parse('<?php echo addslashes(json_encode($getCoordinates(), JSON_HEX_APOS | JSON_HEX_QUOT)) ?>'),
            init() {
                const changeState = (data) => {
                    this.state = data;
                };

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
                    popupAnchor: [0, -20],
                });

                this.dataMarker.map((marker) => {
                    const coordinate = [marker[0], marker[1]];
                    new L.marker(coordinate, { icon: cemeteryIcon })
                        .addTo(this.map)
                        .bindPopup(`<b>${marker[2]}</b><br />RIP`)
                })
            }
        }));
    </script>
    @endscript
</x-dynamic-component>