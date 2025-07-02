@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Return Data</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Return Date</th>
                    <th>Shipment Request ID</th>
                    <th>Return ID</th>
                    <th>Marketplace</th>
                    <th>Authorization ID</th>
                    <th>Vendor Code</th>
                    <th>Invoice Number</th>
                    <th>Warehouse</th>
                    <th>Total Cost</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $row)
                    <tr>
                        <td>{{ $index + $data->firstItem() }}</td>
                        <td>{{ $row->return_date ?? '—' }}</td>
                        <td>{{ $row->shipment_request_id ?? '—' }}</td>
                        <td>{{ $row->return_id ?? '—' }}</td>
                        <td>{{ $row->marketplace ?? '—' }}</td>
                        <td>{{ $row->authorization_id ?? '—' }}</td>
                        <td>{{ $row->vendor_code ?? '—' }}</td>
                        <td>{{ $row->invoice_number ?? '—' }}</td>
                        <td>{{ $row->warehouse ?? '—' }}</td>
                        <td>₹{{ number_format($row->total_cost, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('d-m-Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center text-danger">No Return Records Found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $data->links() }}
    </div>
</div>
@endsection
