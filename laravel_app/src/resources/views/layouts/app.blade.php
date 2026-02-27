<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'MACUIN') — Panel Interno</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="layout">

  <!-- Sidebar de navegación -->
  <aside class="sidebar">
    <div class="sidebar__brand">
      <a href="{{ route('autopartes.index') }}" class="sidebar__logo">MACUIN</a>
      <span class="sidebar__tagline">Panel interno</span>
    </div>

    <p class="sidebar__section-title">Catálogo</p>
    <ul class="sidebar__nav">
      <li class="sidebar__nav-item">
        <a href="{{ route('autopartes.index') }}"
           class="sidebar__nav-link {{ request()->routeIs('autopartes.*') ? 'sidebar__nav-link--active' : '' }}">
          Autopartes
        </a>
      </li>
    </ul>

    <p class="sidebar__section-title">Operaciones</p>
    <ul class="sidebar__nav">
      <li class="sidebar__nav-item">
        <a href="{{ route('inventarios.index') }}"
           class="sidebar__nav-link {{ request()->routeIs('inventarios.index') ? 'sidebar__nav-link--active' : '' }}">
          Inventario
        </a>
      </li>
      <li class="sidebar__nav-item">
        <a href="{{ route('pedidos.index') }}"
           class="sidebar__nav-link {{ request()->routeIs('pedidos.*') ? 'sidebar__nav-link--active' : '' }}">
          Pedidos
        </a>
      </li>
    </ul>

    <div class="sidebar__footer">
      <a href="{{ route('login') }}" class="sidebar__logout">Cerrar sesión</a>
    </div>
  </aside>

  <!-- Contenido principal -->
  <main class="layout__content">
    @yield('content')
  </main>

</div>

</body>
</html>
