<div id="sidebar" class="active">
  <div class="sidebar-wrapper active">
    <div class="sidebar-header">
      <div class="d-flex justify-content-between">
        <div class="logo">
          <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo"
              style="width: 220px; height: auto;" srcset=""></a>
        </div>
        <div class="toggler">
          <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
        </div>
      </div>
    </div>
    <div class="sidebar-menu">
      <ul class="menu">

        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item {{ Request::is('/') ? 'active' : '' }}">
          <a href="{{ url('/') }}" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li
          class="sidebar-item has-sub {{ Request::is('jadwal-pakan*') || Request::is('pakan-manual*') || Request::is('jarak-lontaran*') ? 'active' : '' }}">
          <a href="#" class='sidebar-link'>
            <i class="bi bi-calendar-event-fill"></i>
            <span>Pemberian Pakan</span>
          </a>
          <ul class="submenu {{ Request::is('jadwal-pakan*') || Request::is('pakan-manual*') || Request::is('jarak-lontaran*') ? 'active' : '' }}">
            <li class="submenu-item {{ Request::is('jadwal-pakan*') ? 'active' : '' }}">
              <a href="{{ url('/jadwal-pakan') }}">Otomatis</a>
            </li>
            <li class="submenu-item {{ Request::is('pakan-manual*') ? 'active' : '' }}">
              <a href="{{ url('/pakan-manual') }}">Manual</a>
            </li>
            <li class="submenu-item {{ Request::is('jarak-lontaran*') ? 'active' : '' }}">
              <a href="{{ url('/jarak-lontaran') }}">Jarak Lontaran</a>
            </li>
          </ul>
        </li>

        <li class="sidebar-item {{ Request::is('history') ? 'active' : '' }}">
          <a href="{{ url('/history') }}" class='sidebar-link'>
            <i class="bi bi-clock-history"></i>
            <span>History</span>
          </a>
        </li>

      </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
  </div>
</div>
