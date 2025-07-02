<div class="sidebar bg-light p-3" style="min-height: 100vh; width: 250px;">
    <h4>Dashboard Menu</h4>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="{{ route('df-invoice') }}"><i class="fas fa-file-invoice"></i> DF Invoice Data</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('approved-coogs') }}"><i class="fas fa-check-circle"></i> Approved Coogs Data</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('po-invoice') }}"><i class="fas fa-file-lines"></i> PO Invoice Data</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('remittance') }}"><i class="fas fa-money-bill-trend-up"></i> Remittance Data</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('return-data') }}"><i class="fas fa-rotate-left"></i> Return Data</a></li>
       <li class="nav-item">
  <a class="nav-link {{ request()->is('coogs') ? 'active text-primary fw-bold' : '' }}" href="{{ route('coogs') }}">
    <i class="fas fa-database"></i> Coogs Data
  </a>
</li>

        <li class="nav-item"><a class="nav-link" href="{{ route('coogs') }}"><i class="fas fa-database"></i> Coogs Data</a></li>
    </ul>
</div>
