@extends('partials.index')

@section('script-head')
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
    @enderror
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row justify-content-center">
        @if (auth()->user()->role->name == 'admin')
            <div class="col-2 text-end">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#importProvinceModal"><i
                        class="bi bi-arrow-down-circle"></i> Import</button>
            </div>
        @endif
        <div class="col-5">
            <form action="{{ route('province.index') }}" method="GET">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Search</span>
                    <input type="text" class="form-control" aria-label="Sizing example input" name="search"
                        aria-describedby="inputGroup-sizing-default" placeholder="search by name">
                    <button type="input" class="btn btn-dark ms-2"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
        @if (auth()->user()->role->name == 'admin')
            <div class="col-2">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addProvinceModal">Add
                    province</button>
            </div>
        @endif
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Map</th>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Large Area</th>
                <th scope="col">Total Population</th>
                <th scope="col">Regional Center</th>
                @if (auth()->user()->role->name == 'admin')
                    <th scope="col">Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $index => $data)
                <tr>
                    <td><a href="{{ route('map.province.index', $data->id) }}" class="btn btn-outline-dark"><i
                                class="bi bi-geo-alt"></i></a></td>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->large_area ?? '-' }}</td>
                    <td>{{ $data->total_population ?? '-' }}</td>
                    <td>{{ $data->regional_center ?? '-' }}</td>
                    @if (auth()->user()->role->name == 'admin')
                        <td>
                            <div class="row">
                                <div class="col">
                                    <a type="button" class="btn btn-warning update-btn"
                                        href="{{ route('province.update.form', $data->id) }}">Update</a>
                                </div>
                                <div class="col">
                                    <form action="{{ route('province.destroy', $data->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i>
                                            Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row justify-content-center">
        <div class="col-6">
            {{ $datas->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Modal untuk menambahkan provinsi -->
    <div class="modal fade" id="addProvinceModal" tabindex="-1" aria-labelledby="addProvinceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProvinceModalLabel">Add Province</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('province.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- <div class="mb-3">
                            <label for="name" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id" required>
                        </div> --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Large Area</label>
                            <input type="text" class="form-control" id="name" name="large_area" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Total Population</label>
                            <input type="text" class="form-control" id="name" name="total_population" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Regional Center</label>
                            <input type="text" class="form-control" id="name" name="regional_center" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importProvinceModal" tabindex="-1" aria-labelledby="importProvinceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importProvinceModalLabel">Import Province</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('province.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Select Excel File</label>
                            <input type="file" class="form-control" id="excel_file" name="file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambah wilayah -->
    <div class="modal fade" id="addRegionModal" tabindex="-1" aria-labelledby="addRegionModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importProvinceModalLabel">Import Province</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="" id="map" style="height: 400px"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="addRegionButton" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-body')
@endsection
