@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')

<div class="page-header">
  <div>
    <h1 class="page-header__title">Gestión de Pedidos</h1>
    <p class="page-header__subtitle">Seguimiento y control de órdenes</p>
  </div>
  <a href="#" class="btn btn--primary">+ Agregar Pedido</a>
</div>

<!-- Contadores -->
<div class="stats-row">
  <div class="stat-card stat-card--success">
    <div class="stat-card__label">Completados</div>
    <div class="stat-card__value">{{ $completados }}</div>
  </div>
  <div class="stat-card stat-card--warning">
    <div class="stat-card__label">Pendientes</div>
    <div class="stat-card__value">{{ $pendientes }}</div>
  </div>
  <div class="stat-card stat-card--danger">
    <div class="stat-card__label">Cancelados</div>
    <div class="stat-card__value">{{ $cancelados }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-card__label">Total</div>
    <div class="stat-card__value">{{ $total_pedidos }}</div>
  </div>
</div>

<!-- Filtros -->
<div class="filters">
  <select class="filters__select">
    <option value="">Todos los estados</option>
    @foreach($estados as $estado)
      <option value="{{ $estado }}">{{ $estado }}</option>
    @endforeach
  </select>
  <input class="filters__date" type="date" title="Fecha desde">
  <input class="filters__date" type="date" title="Fecha hasta">
  <input class="filters__input" type="text" placeholder="Buscar por cliente o ID…">
</div>

<!-- Tabla -->
<div class="table-wrapper">
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th></th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Total</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pedidos as $pedido)
      <tr>
        <td>#{{ str_pad($pedido['id'], 3, '0', STR_PAD_LEFT) }}</td>
        <td><span class="table__img-placeholder"></span></td>
        <td><strong>{{ $pedido['cliente'] }}</strong></td>
        <td>{{ $pedido['fecha'] }}</td>
        <td>
          <span class="badge badge--{{ strtolower($pedido['estado']) }}">{{ $pedido['estado'] }}</span>
        </td>
        <td>${{ number_format($pedido['total'], 2) }}</td>
        <td>
          <a href="{{ route('pedidos.show', $pedido['id']) }}" class="btn btn--secondary btn--sm">Ver detalle</a>
          <button class="btn btn--danger btn--sm">Eliminar</button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="pagination">
    <span class="pagination__info">Mostrando {{ count($pedidos) }} de {{ count($pedidos) }} registros</span>
    <a href="#" class="pagination__btn">«</a>
    <a href="#" class="pagination__btn pagination__btn--active">1</a>
    <a href="#" class="pagination__btn">2</a>
    <a href="#" class="pagination__btn">»</a>
  </div>
</div>

@endsection
