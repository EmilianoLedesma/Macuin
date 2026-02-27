@extends('layouts.app')

@section('title', 'Autopartes')

@section('content')

<div class="page-header">
  <div>
    <h1 class="page-header__title">Autopartes</h1>
    <p class="page-header__subtitle">Catálogo general de productos</p>
  </div>
  <a href="{{ route('autopartes.create') }}" class="btn btn--primary">+ Agregar Autoparte</a>
</div>

<!-- Contadores -->
<div class="stats-row">
  <div class="stat-card stat-card--success">
    <div class="stat-card__label">En stock</div>
    <div class="stat-card__value">{{ $en_stock }}</div>
  </div>
  <div class="stat-card stat-card--warning">
    <div class="stat-card__label">Bajo stock</div>
    <div class="stat-card__value">{{ $bajo_stock }}</div>
  </div>
  <div class="stat-card stat-card--danger">
    <div class="stat-card__label">Sin stock</div>
    <div class="stat-card__value">{{ $sin_stock }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-card__label">Categorías</div>
    <div class="stat-card__value">{{ $total_cats }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-card__label">Marcas</div>
    <div class="stat-card__value">{{ $total_marcas }}</div>
  </div>
</div>

<!-- Filtros -->
<div class="filters">
  <select class="filters__select">
    <option value="">Todas las categorías</option>
    @foreach($categorias as $cat)
      <option value="{{ $cat['id'] }}">{{ $cat['nombre'] }}</option>
    @endforeach
  </select>
  <select class="filters__select">
    <option value="">Todas las marcas</option>
    @foreach($marcas as $marca)
      <option value="{{ $marca }}">{{ $marca }}</option>
    @endforeach
  </select>
  <input class="filters__input" type="text" placeholder="Buscar por nombre o descripción…">
</div>

<!-- Tabla -->
<div class="table-wrapper">
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Marca</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($autopartes as $autoparte)
      <tr>
        <td>#{{ str_pad($autoparte['id'], 3, '0', STR_PAD_LEFT) }}</td>
        <td><strong>{{ $autoparte['nombre'] }}</strong></td>
        <td>{{ $autoparte['categoria'] }}</td>
        <td>{{ $autoparte['marca'] }}</td>
        <td>${{ number_format($autoparte['precio'], 2) }}</td>
        <td>{{ $autoparte['stock'] }}</td>
        <td>
          @if($autoparte['estado'] === 'Disponible')
            <span class="badge badge--disponible">Disponible</span>
          @elseif($autoparte['estado'] === 'Bajo stock')
            <span class="badge badge--bajo-stock">Bajo stock</span>
          @else
            <span class="badge badge--sin-stock">Sin stock</span>
          @endif
        </td>
        <td>
          <a href="{{ route('autopartes.edit', $autoparte['id']) }}" class="btn btn--secondary btn--sm">Editar</a>
          <button class="btn btn--danger btn--sm">Eliminar</button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Paginación -->
  <div class="pagination">
    <span class="pagination__info">Mostrando {{ count($autopartes) }} de {{ count($autopartes) }} registros</span>
    <a href="#" class="pagination__btn">«</a>
    <a href="#" class="pagination__btn pagination__btn--active">1</a>
    <a href="#" class="pagination__btn">2</a>
    <a href="#" class="pagination__btn">»</a>
  </div>
</div>

@endsection
