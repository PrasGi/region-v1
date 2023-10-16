@extends('partials.index')

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
    @error('names')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror

    <div class="row justify-content-center">
        <div class="col-7">
            <div class="shadow p-5">
                <div class="text-center fs-3">
                    <b>Regency update</b>
                </div>
                <form action="{{ route('regency.update', $regency->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Province ID</label>
                            <input type="text" class="form-control" id="id" name="province_id"
                                value="{{ $regency->province_id }}" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="name" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id"
                                value="{{ $regency->id }}" required>
                        </div> --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $regency->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Large Area</label>
                            <input type="text" class="form-control" id="name" name="large_area"
                                value="{{ $regency->large_area }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Total Population</label>
                            <input type="text" class="form-control" id="name" name="total_population"
                                value="{{ $regency->total_population }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Regional Center</label>
                            <input type="text" class="form-control" id="name" name="regional_center"
                                value="{{ $regency->regional_center }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
