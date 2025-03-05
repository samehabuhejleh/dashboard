<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100%;">
  <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <svg class="bi me-2" width="40" height="32">
      <use xlink:href="#bootstrap"></use>
    </svg>
    <span class="fs-4">Dashboard</span>
  </a>
  <hr>


  @if(Auth::user()->hasRole('super_admin'))
  @include('layouts.components.sidebar-menu.super-admin')
  @endif
  @if(Auth::user()->hasRole('admin'))
  @include('layouts.components.sidebar-menu.admin')
  @endif
  @if(Auth::user()->hasRole('user'))
  @include('layouts.components.sidebar-menu.user')

  @endif

  <hr>
</div>