<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img src="{{ avatar_path(Auth::user()->image) }}" alt="profile image"> </div>
          <div class="text-wrapper">
            <p class="profile-name">{{ Auth::user()->name }}</p>
            <div>
              <small class="designation text-muted">{{ Auth::user()->roleName() }}</small>
              <span class="status-indicator online"></span>
            </div>
          </div>
        </div>
        <button class="btn btn-success btn-block">New Project
          <i class="mdi mdi-plus"></i>
        </button>
      </div>
    </li>

    <li class="nav-item {{ active_path() }}">
      <a class="nav-link" href="{{ route('admin.index') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- User management -->
    <li class="nav-item {{ active_segment(2, 'users') }}">
      <a class="nav-link" data-toggle="collapse" href="#user-dropdown" aria-expanded="false" aria-controls="user-dropdown">
        <i class="menu-icon mdi mdi-account-group"></i>
        <span class="menu-title">User Management</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_segment(2, 'users') }}" id="user-dropdown">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ active_path('users') }}" href="{{ route('admin.users.index') }}">User Lists</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ active_path('users/create') }}" href="{{ route('admin.users.create') }}">Add New User</a>
          </li>
        </ul>
      </div>
    </li>

    
  </ul>
</nav>
