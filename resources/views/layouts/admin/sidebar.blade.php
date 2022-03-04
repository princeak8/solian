<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('admin/')}}">
  <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-laugh-wink"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Solian </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
  <a class="nav-link" href="{{url('/admin')}}">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav links -->

<li class="nav-item">
  <a class="nav-link" href="{{url('admin/company')}}">
    <i class="fas fa-fw fa-folder"></i>
    <span>Company Settings</span>
  </a>
</li>

<!--
<li class="nav-item">
  <a class="nav-link" href="{{url('admin/admins')}}">
    <i class="fas fa-fw fa-folder"></i>
    <span>Admins</span>
  </a>
</li>
-->

<li class="nav-item">
  <a class="nav-link" href="{{url('admin/products')}}">
    <i class="fas fa-fw fa-folder"></i>
    <span>Products</span>
    <span>[ <span  class="side-count">{{$productCount}}</span> ]</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{url('admin/collections')}}">
    <i class="fas fa-fw fa-folder"></i>
    <span>Collections</span>
    <span>[ <span class="side-count">{{$collectionCount}}</span> ]</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link"  href="{{url('admin/orders')}}">
    <i class="fas fa-fw fa-folder"></i>
    <span>Orders</span>
    <span>[ <span class="side-count">{{$pendingOrderCount}}</span> ]</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="charts.html">
    <i class="fas fa-fw fa-folder"></i>
    <span>Payments</span>
    <span>[ <span class="side-count">{{$unconfirmedPaymentCount}}</span> ]</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link"  href="{{url('admin/slides')}}">
    <i class="fas fa-fw fa-folder"></i>
    <span>Slides</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link"  href="{{url('admin/sizes')}}">
    <i class="fas fa-fw fa-folder"></i>
    <span>Sizes</span>
  </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">
<!--
<!- Heading --
<div class="sidebar-heading">
  Addons
</div>

<!- Nav Item - Pages Collapse Menu --
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
    <i class="fas fa-fw fa-folder"></i>
    <span>Pages</span>
  </a>
  <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Login Screens:</h6>
      <a class="collapse-item" href="login.html">Login</a>
      <a class="collapse-item" href="register.html">Register</a>
      <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
      <div class="collapse-divider"></div>
      <h6 class="collapse-header">Other Pages:</h6>
      <a class="collapse-item" href="404.html">404 Page</a>
      <a class="collapse-item" href="blank.html">Blank Page</a>
    </div>
  </div>
</li>

<!- Nav Item - Charts --
<li class="nav-item">
  <a class="nav-link" href="charts.html">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>Charts</span></a>
</li>

<!- Nav Item - Tables --
<li class="nav-item">
  <a class="nav-link" href="tables.html">
    <i class="fas fa-fw fa-table"></i>
    <span>Tables</span></a>
</li>

<!- Divider --
<hr class="sidebar-divider d-none d-md-block">
-->
<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>