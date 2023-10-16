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
                    <b>District update</b>
                </div>
                <form action="{{ route('district.update', $district->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Regency ID</label>
                            <input type="text" class="form-control" id="id" name="regency_id"
                                value="{{ $district->regency_id }}" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="name" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id"
                                value="{{ $district->id }}" required>
                        </div> --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $district->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Large Area</label>
                            <input type="text" class="form-control" id="name" name="large_area"
                                value="{{ $district->large_area }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Total Population</label>
                            <input type="text" class="form-control" id="name" name="total_population"
                                value="{{ $district->total_population }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Regional Center</label>
                            <input type="text" class="form-control" id="name" name="regional_center"
                                value="{{ $district->regional_center }}" required>
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
