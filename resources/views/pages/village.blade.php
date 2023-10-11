@extends('partials.index')

@section('content')
    @error('failed')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror
    @error('regency_id')
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
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-5">
            <form action="{{ route('village.index') }}" method="GET">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" aria-label="Sizing example input" name="search"
                        aria-describedby="inputGroup-sizing-default" placeholder="search by name or district id">
                    <button type="input" class="btn btn-dark ms-2">Search</button>
                </div>
            </form>
        </div>
        <div class="col-2">
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addProvinceModal">Add
                village</button>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>
                        <div class="row">
                            <div class="col-2">
                                <a type="button" class="btn btn-warning update-btn"
                                    href="{{ route('village.update.form', $data->id) }}">Update</a>
                            </div>
                            <div class="col-3">
                                <form action="{{ route('village.destroy', $data->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i>
                                        Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
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
    <div class="modal
            fade" id="addProvinceModal" tabindex="-1" aria-labelledby="addProvinceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProvinceModalLabel">Add Village</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('village.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">District ID</label>
                            <input type="text" class="form-control" id="id" name="district_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
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
@endsection