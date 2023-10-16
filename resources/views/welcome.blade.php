@extends('partials.index')

@section('content')
    <!-- Penjelasan Penggunaan API -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">API Usage</h5>
            <p class="card-text">
                Base URL : <strong>{{ env('APP_URL') }}/api</strong> <br>
                You can access the following API endpoints to manage regions:
            <ul>
                <li>/provinces
                    <ul>
                        <li>Header: X-TOKEN-REGION: [token]</li>
                        <li>Param: name, per_page</li>
                    </ul>
                </li>
                <li>/regencies
                    <ul>
                        <li>Header: X-TOKEN-REGION: [token]</li>
                        <li>Param: province_id, name, per_page</li>
                    </ul>
                </li>
                <li>/districts
                    <ul>
                        <li>Header: X-TOKEN-REGION: [token]</li>
                        <li>Param: regency_id, name, per_page</li>
                    </ul>
                </li>
                <li>/villages
                    <ul>
                        <li>Header: X-TOKEN-REGION: [token]</li>
                        <li>Param: district_id, name, per_page</li>
                    </ul>
                </li>
            </ul>
            </p>
        </div>
    </div>
@endsection
