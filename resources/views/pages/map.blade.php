@extends('partials.index')

@section('script-head')
    <!-- Letakkan script Leaflet di sini -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://unpkg.com/wellknown@0.5.0/wellknown.js"></script>

    <style>
        #map {
            height: 600px;
        }
    </style>
@endsection

@section('content')
    @error('failed')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror
    @error('id')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror
    @error('name')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror
    @error('file')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div id="map"></div>
        <div class="row justify-content-center">
            <div class="col-3 text-center">
                <div class="mt-4">
                    <button id="clearButton" class="btn btn-outline-dark">Clear</button>
                    <button id="updateButton" class="btn btn-dark">Update</button> <!-- Perubahan tombol Show ke Update -->
                    <button id="importButton" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#importModal"><i
                            class="bi bi-arrow-down-circle"></i> Import</button>
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Detail
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Name {{ $type }} : {{ $province->name }}</h5>
                    </div>
                </div>
            </div>
        </div>
        {{-- <p>{{ $province->region }}</p> --}}

        <!-- Modal untuk mengunggah file -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Location Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="importForm" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="gcp_file">Choose a file</label>
                                <input type="file" class="form-control" id="gcp_file" name="file" required>
                                <input type="hidden" class="form-control" id="gcp_file" name="province_id" required
                                    value="{{ $province->id }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="importSubmitButton" class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('script-body')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery library --> --}}

        <script>
            var map = L.map('map').setView([51.505, -0.09], 13);
            var geojsonLayer = null;

            L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);

            var drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            var drawControl = new L.Control.Draw({
                edit: {
                    featureGroup: drawnItems
                },
                draw: {
                    polygon: true,
                    marker: false,
                    circle: false,
                    circlemarker: false,
                    polyline: false
                }
            });
            map.addControl(drawControl);

            var selectedAreaLayer = new L.FeatureGroup();
            map.addLayer(selectedAreaLayer);

            var userDrawnArea;

            map.on('draw:created', function(e) {
                selectedAreaLayer.clearLayers();
                geojsonLayer.clearLayers();

                var layer = e.layer;
                drawnItems.addLayer(layer);
                userDrawnArea = drawnItems.toGeoJSON();
            });

            document.getElementById('clearButton').addEventListener('click', function() {
                drawnItems.clearLayers();
                userDrawnArea = null;
                selectedAreaLayer.clearLayers();
            });

            document.getElementById('updateButton').addEventListener('click', function() {
                if (userDrawnArea) {
                    console.log(userDrawnArea);
                    $.ajax({
                        type: 'POST',
                        url: '/api/province/update/region',
                        data: {
                            id: '{{ $province->id }}',
                            userDrawnArea: JSON.stringify(userDrawnArea)
                        },
                        success: function(response) {
                            toastr.success('Data berhasil diperbarui');
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        },
                        error: function(err) {
                            toastr.error('Terjadi kesalahan saat memperbarui data');
                        }
                    });
                }
            });

            // Cek apakah $wktData ada
            @if ($wktData)
                var wktData = "{!! $wktData !!}"; // Mendapatkan data WKT dari PHP
                console.log("wktData", wktData);

                // Konversi WKT ke GeoJSON menggunakan wellknown
                var geojsonData = wellknown.parse(wktData);

                console.log("geojsonData", geojsonData);
                // Sekarang, geojsonData berisi data GeoJSON yang dapat Anda gunakan
                geojsonLayer = L.geoJSON(geojsonData);
                geojsonLayer.addTo(map);

                // Fokuskan peta ke area yang ditampilkan
                map.fitBounds(geojsonLayer.getBounds());
            @else
                // Jika tidak ada data WKT, fokuskan peta pada Jakarta, Indonesia
                map.setView([-6.2088, 106.8456], 13);
            @endif
        </script>

        <!-- JavaScript code to handle form submission -->
        <script>
            $(document).ready(function() {
                $("#importSubmitButton").on('click', function() {
                    var formData = new FormData($('#importForm')[0]);

                    $.ajax({
                        type: 'POST',
                        url: '/api/import/province/location',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            toastr.success('Data berhasil diimpor');
                            $('#importModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                            // Add any additional actions here after successful import
                        },
                        error: function(err) {
                            toastr.error('Terjadi kesalahan saat mengimpor data');
                            // Handle errors here
                        }
                    });
                });
            });
        </script>
    @endsection
