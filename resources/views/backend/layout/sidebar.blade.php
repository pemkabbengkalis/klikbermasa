<!-- Sidebar menu -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{ ucfirst(Auth::user()->name) }}</p>
            <p class="app-sidebar__user-designation">{{ ucfirst(Auth::user()->level) }}</p>
        </div>
    </div>
    <ul class="app-menu">
        @php $level = Auth::user()->level; @endphp
        <li>
            <a class="app-menu__item" href="{{ route('dashboard') }}">
                <i class="app-menu__icon bi bi-speedometer"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        {{-- <li class="treeview {{ active_treeview(['']) }}">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon bi bi-view-list"></i>
                <span class="app-menu__label">Data Master</span>
                <i class="treeview-indicator bi bi-chevron-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="{{ route('instansi.index') }}">
                        <i class="icon bi bi-building"></i> Instansi
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="{{ route('instansi.index') }}">
                        <i class="icon bi bi-building"></i> Instansi
                    </a>
                </li>
            </ul>
        </li> --}}
        <li class="">
            <a class="app-menu__item {{ config('menu.active.path') =='layanan' ? 'active':'' }}" href="{{ route('layanan.index') }}">
                <i class="app-menu__icon bi bi-card-checklist"></i>
                <span class="app-menu__label">Layanan </span>
            </a>
        </li>
        <li>
            <a class="app-menu__item  {{ config('menu.active.path') =='kategori' ? 'active':'' }}" href="{{ route('kategori.index') }}">
                <i class="app-menu__icon bi bi-tags"></i>
                <span class="app-menu__label">Kategori</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item  {{ config('menu.active.path') =='instansi' ? 'active':'' }}" href="{{ route('instansi.index') }}">
                <i class="app-menu__icon bi bi-building"></i>
                <span class="app-menu__label">Instansi</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item  {{ config('menu.active.path') =='instansi' ? 'active':'' }}" href="{{ route('user.index') }}">
                <i class="app-menu__icon bi bi-people"></i>
                <span class="app-menu__label">Pengguna</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ config('menu.active.path') =='setting' ? 'active':'' }}" href="{{ route('setting') }}">
                <i class="app-menu__icon bi bi-gear"></i>
                <span class="app-menu__label">Pengaturan</span>
            </a>
        </li>
    </ul>
</aside>
