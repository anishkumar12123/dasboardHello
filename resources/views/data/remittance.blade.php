@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Remittance Data</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Payment Number</th>
                    <th>Invoice Number</th>
                    <th>Invoice Date</th>
                    <th>Transaction Type</th>
                    <th>Transaction Description</th>
                    <th>Invoice Amount</th>
                    <th>Amount Paid</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $row)
                    <tr>
                        <td>{{ $index + $data->firstItem() }}</td>
                        <td>{{ $row->payment_number ?? '—' }}</td>
                        <td>{{ $row->invoice_number ?? '—' }}</td>
                        <td>{{ $row->invoice_date ? \Carbon\Carbon::parse($row->invoice_date)->format('d-m-Y') : '—' }}</td>
                        <td>{{ $row->transaction_type ?? '—' }}</td>
                        <td>{{ $row->transaction_description ?? '—' }}</td>
                        <td>₹{{ $row->invoice_amount ? number_format($row->invoice_amount, 2) : '0.00' }}</td>
                        <td>₹{{ $row->amount_paid ? number_format($row->amount_paid, 2) : '0.00' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('d-m-Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-danger">No Remittance Records Found.</td>
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
