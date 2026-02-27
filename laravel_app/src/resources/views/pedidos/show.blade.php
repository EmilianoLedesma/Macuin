@extends('layouts.app')

@section('title')
Pedido #{{ str_pad($pedido_id, 3, '0', STR_PAD_LEFT) }}
@endsection

@section('content')

<!-- Breadcrumb -->
<nav class="breadcrumb">
  <a href="{{ route('autopartes.index') }}">Inicio</a>
  <span class="breadcrumb__sep">/</span>
  <a href="{{ route('pedidos.index') }}">Gestión de Pedidos</a>
  <span class="breadcrumb__sep">/</span>
  <span>Pedido #{{ str_pad($pedido_id, 3, '0', STR_PAD_LEFT) }}</span>
</nav>

<div class="page-header">
  <div>
    <h1 class="page-header__title">Pedido #{{ str_pad($pedido_id, 3, '0', STR_PAD_LEFT) }}</h1>
    <p class="page-header__subtitle">
      @if($detalle)
        Realizado el {{ $detalle['pedido']['fecha'] }}
      @endif
    </p>
  </div>
  <a href="{{ route('pedidos.index') }}" class="btn btn--secondary">← Volver a pedidos</a>
</div>

@if($detalle)

<!-- Dos columnas: datos del cliente + resumen del pedido -->
<div class="detail-grid">

  <div class="detail-card">
    <div class="detail-card__title">Información del cliente</div>
    <div class="detail-card__row">
      <span class="detail-card__field">Nombre</span>
      <span class="detail-card__value">{{ $detalle['pedido']['cliente'] }}</span>
    </div>
    <div class="detail-card__row">
      <span class="detail-card__field">Teléfono</span>
      <span class="detail-card__value">{{ $detalle['pedido']['telefono'] }}</span>
    </div>
    <div class="detail-card__row">
      <span class="detail-card__field">Correo</span>
      <span class="detail-card__value">{{ $detalle['pedido']['email'] }}</span>
    </div>
  </div>

  <div class="detail-card">
    <div class="detail-card__title">Resumen del pedido</div>
    <div class="detail-card__row">
      <span class="detail-card__field">Estado actual</span>
      <span class="detail-card__value">
        <span class="badge badge--{{ strtolower($detalle['pedido']['estado']) }}">{{ $detalle['pedido']['estado'] }}</span>
      </span>
    </div>
    <div class="detail-card__row">
      <span class="detail-card__field">Fecha</span>
      <span class="detail-card__value">{{ $detalle['pedido']['fecha'] }}</span>
    </div>
    <div class="detail-card__row">
      <span class="detail-card__field">Total</span>
      <span class="detail-card__value">${{ number_format($detalle['total'], 2) }}</span>
    </div>
  </div>

</div>

<!-- Tabla de autopartes del pedido -->
<div class="table-wrapper">
  <table class="table">
    <thead>
      <tr>
        <th>Autoparte</th>
        <th>Cantidad</th>
        <th>Precio unitario</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($detalle['items'] as $item)
      <tr>
        <td><strong>{{ $item['nombre'] }}</strong></td>
        <td>{{ $item['cantidad'] }}</td>
        <td>${{ number_format($item['precio_unitario'], 2) }}</td>
        <td>${{ number_format($item['subtotal'], 2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="detail-total">
    Total del pedido <span>${{ number_format($detalle['total'], 2) }}</span>
  </div>
</div>

<!-- Cambiar estado -->
<div class="status-change">
  <label class="form__label" style="margin:0">Cambiar estado:</label>
  <select class="filters__select">
    @foreach($estados as $estado)
      <option value="{{ $estado }}"
        {{ $detalle['pedido']['estado'] === $estado ? 'selected' : '' }}>
        {{ $estado }}
      </option>
    @endforeach
  </select>
  <button class="btn btn--primary btn--sm">Aplicar cambio</button>
</div>

@else
  <p>Pedido no encontrado.</p>
@endif

@endsection
