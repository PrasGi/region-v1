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
                    <b>Village update</b>
                </div>
                <form action="{{ route('village.update', $village->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">District ID</label>
                            <input type="text" class="form-control" id="id" name="district_id"
                                value="{{ $village->district_id }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id"
                                value="{{ $village->id }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $village->name }}" required>
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
