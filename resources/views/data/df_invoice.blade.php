@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Coogs Data</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Sale Order No.</th>
                    <th>Invoice Number</th>
                    <th>Channel Entry</th>
                    <th>Product Name</th>
                    <th>SKU Code</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Currency</th>
                    <th>Total</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $row)
                <tr>
                    <td>{{ $index + $data->firstItem() }}</td>
                    <td>{{ $row->date ? \Carbon\Carbon::parse($row->date)->format('d-m-Y') : '—' }}</td>
                    <td>{{ $row->sale_order_number ?? '—' }}</td>
                    <td>{{ $row->invoice_number ?? '—' }}</td>
                    <td>{{ $row->channel_entry ?? '—' }}</td>
                    <td>{{ $row->product_name ?? '—' }}</td>
                    <td>{{ $row->product_sku_code ?? '—' }}</td>
                    <td>{{ $row->qty ?? 0 }}</td>
                    <td>₹{{ number_format($row->unit_price ?? 0, 2) }}</td>
                    <td>{{ $row->currency ?? 'INR' }}</td>
                    <td>₹{{ number_format($row->total ?? 0, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center text-danger">No Coogs Data Found.</td>
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
