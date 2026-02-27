@extends('layouts.app')

@section('title', 'Inventario')

@section('content')

<div class="page-header">
  <div>
    <h1 class="page-header__title">Gestión de Inventario</h1>
    <p class="page-header__subtitle">Control de stock por autoparte</p>
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
  <input class="filters__input" type="text" placeholder="Buscar autoparte…">
</div>

<!-- Tabla de inventario -->
<div class="table-wrapper">
  <table class="table">
    <thead>
      <tr>
        <th>Autoparte</th>
        <th>Categoría</th>
        <th>Stock Actual</th>
        <th>Stock Mínimo</th>
        <th>Estado</th>
        <th>Actualización</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($inventarios as $item)
      <tr class="{{ $item['estado'] === 'Sin stock' ? 'table__row--danger' : ($item['estado'] === 'Bajo stock' ? 'table__row--warning' : '') }}">
        <td><strong>{{ $item['autoparte'] }}</strong></td>
        <td>{{ $item['categoria'] }}</td>
        <td>{{ $item['stock_actual'] }}</td>
        <td>{{ $item['stock_minimo'] }}</td>
        <td>
          @if($item['estado'] === 'En stock')
            <span class="badge badge--en-stock">En stock</span>
          @elseif($item['estado'] === 'Bajo stock')
            <span class="badge badge--bajo-stock">Bajo stock</span>
          @else
            <span class="badge badge--sin-stock">Sin stock</span>
          @endif
        </td>
        <td>{{ $item['fecha_actualizacion'] }}</td>
        <td>
          <button class="btn btn--secondary btn--sm">Actualizar stock</button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="pagination">
    <span class="pagination__info">Mostrando {{ count($inventarios) }} de {{ count($inventarios) }} registros</span>
    <a href="#" class="pagination__btn">«</a>
    <a href="#" class="pagination__btn pagination__btn--active">1</a>
    <a href="#" class="pagination__btn">»</a>
  </div>
</div>

@endsection
