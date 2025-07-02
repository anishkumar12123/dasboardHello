<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - BananaYello</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
    .sidebar {
      height: 100vh; background-color: #1f2d3d; color: #fff;
      padding-top: 20px; position: fixed; left: 0; top: 0; width: 220px;
    }
    .sidebar a {
      color: #cfd8dc; text-decoration: none; display: block;
      padding: 12px 20px; transition: all 0.3s ease;
    }
    .sidebar a:hover { background-color: #3c4b64; color: #fff; }
    .main-content { margin-left: 220px; }
    .top-bar {
      background-color: #3c8dbc; color: white;
      padding: 15px 30px; display: flex; justify-content: space-between;
      align-items: center;
    }
    .card-box {
      padding: 20px; color: white; border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s ease;
    }
    .card-box:hover { transform: translateY(-5px); }
  </style>
</head>
<body>

  <div class="sidebar">
    <h4 class="text-center">BananaYello</h4>
    <a href="{{ url('/') }}"><i class="fas fa-gauge"></i> Dashboard</a>
    <a href="{{ route('df-invoice') }}"><i class="fas fa-file-invoice"></i> DF Invoice Data</a>
    <a href="{{ route('approved-coogs') }}"><i class="fas fa-check-circle"></i> Approved Coogs Data</a>
    <a href="{{ route('po-invoice') }}"><i class="fas fa-file-lines"></i> PO Invoice Data</a>
    <a href="{{ route('remittance') }}"><i class="fas fa-money-bill-trend-up"></i> Remittance Data</a>
    <a href="{{ route('return-data') }}"><i class="fas fa-rotate-left"></i> Return Data</a>
    <a href="{{ route('coogs') }}"><i class="fas fa-database"></i> Coogs Data</a>
  </div>

  <div class="main-content">
    <div class="top-bar">
      <h4>Dashboard <strong>BananaYello</strong></h4>
      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2 upload-section">
          @csrf
          <input type="file" name="excel_file" class="form-control form-control-sm" accept=".xlsx,.xls,.csv" required>
          <button type="submit" class="btn btn-light btn-sm">Upload</button>
        </form>
        <i class="fas fa-user-circle fa-2x"></i> Admin
      </div>
    </div>

    <div class="p-4">
      <!-- Fixed cards (including Coogs Total Amount) -->
      <div class="row g-3">
        <div class="col-md-4">
          <div class="card-box bg-danger">
            <h5>₹5,881,925.78</h5>
            <p>Your Receivables</p>
            <a href="#" class="btn btn-light btn-sm">Download Invoice <i class="fas fa-download"></i></a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box bg-danger">
            <h5>₹97,657,812.27</h5>
            <p>Your Remittance</p>
            <a href="#" class="btn btn-light btn-sm">Download Invoice <i class="fas fa-download"></i></a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box bg-success">
            <h5>₹12,132,395.37</h5>
            <p>Your Payables</p>
            <a href="#" class="btn btn-light btn-sm">Download Invoice <i class="fas fa-download"></i></a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box bg-info">
            <h5>₹25,685,190.40</h5>
            <p>DF Invoice Total Amount</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box bg-success">
            <h5>₹115,672,133.42</h5>
            <p>Total Sale Amount</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box bg-primary">
            <h5>₹89,986,943.02</h5>
            <p>PO Invoice Total Amount</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box bg-danger">
            <h5>₹97,657,812.27</h5>
            <p>Remittance Total Amount</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box bg-info">
            <h5>₹4,967,361.63</h5>
            <p>Return Total Amount</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box bg-danger">
            <h5>₹7,165,033.74</h5>
            <p>Coogs Total Amount</p>
          </div>
        </div>
      </div>

      <!-- Dynamic page content -->
      <div class="mt-4">
        @yield('content')
      </div>
    </div>
  </div>

</body>
</html>
