@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Approved Coogs Data</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>ASIN</th>
                <th>Gross Ship GMS</th>
                <th>Net Ship GMS</th>
                <th>Order Date</th>
                <th>Net Ship Units</th>
                <th>Duration</th>
                <th>Net Net</th>
                <th>Net Served</th>
                <th>Coop</th>
                <th>Final Coop</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
            <tr>
                <td>{{ $index + $data->firstItem() }}</td>
                <td>{{ $row->asin }}</td>
                <td>{{ $row->gross_ship_gms }}</td>
                <td>{{ $row->net_ship_gms }}</td>
                <td>{{ \Carbon\Carbon::parse($row->order_date)->format('d-m-Y') }}</td>
                <td>{{ $row->net_ship_units }}</td>
                <td>{{ $row->duration }}</td>
                <td>{{ $row->net_net }}</td>
                <td>{{ $row->net_served }}</td>
                <td>{{ $row->coop }}</td>
                <td>{{ $row->final_coop }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11">No data available</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $data->links() }}
    </div>
</div>
@endsection
