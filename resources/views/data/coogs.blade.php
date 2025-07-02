@extends('layouts.dashboard')

@section('content')
<h3>Coogs Data Table</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Invoice ID</th>
      <th>Invoice Date</th>
      <th>Agreement ID</th>
      <th>Agreement Title</th>
      <th>Funding Type</th>
      <th>Original Balance</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $row)
      <tr>
        <td>{{ $row->invoice_id }}</td>
        <td>{{ $row->invoice_date }}</td>
        <td>{{ $row->agreement_id }}</td>
        <td>{{ $row->agreement_title }}</td>
        <td>{{ $row->funding_type }}</td>
        <td>{{ $row->original_balance }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
{{ $data->links() }}
@endsection
