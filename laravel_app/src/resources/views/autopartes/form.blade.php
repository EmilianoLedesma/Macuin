@extends('layouts.app')

@section('title', $modo === 'nueva' ? 'Nueva Autoparte' : 'Editar Autoparte')

@section('content')

<div class="page-header">
  <div>
    <h1 class="page-header__title">
      {{ $modo === 'nueva' ? 'Nueva Autoparte' : 'Editar Autoparte' }}
    </h1>
    <p class="page-header__subtitle">
      @if($modo === 'nueva')
        Completa los campos para registrar una nueva autoparte en el catálogo.
      @else
        Modifica los datos de la autoparte seleccionada.
      @endif
    </p>
  </div>
  <a href="{{ route('autopartes.index') }}" class="btn btn--secondary">← Volver al listado</a>
</div>

<div class="form-card">
  <form method="post" action="#">

    <!-- Nombre -->
    <div class="form-row">
      <label class="form__label" for="nombre">Nombre de la autoparte</label>
      <input
        class="form__input"
        type="text"
        id="nombre"
        name="nombre"
        placeholder="Ej. Filtro de aceite premium"
        value="{{ $autoparte['nombre'] ?? '' }}"
        required
      >
    </div>

    <!-- Descripción -->
    <div class="form-row">
      <label class="form__label" for="descripcion">Descripción</label>
      <textarea
        class="form__textarea"
        id="descripcion"
        name="descripcion"
        placeholder="Descripción técnica de la autoparte, compatibilidad, especificaciones…"
      >{{ $autoparte['descripcion'] ?? '' }}</textarea>
    </div>

    <!-- Categoría + Marca -->
    <div class="form-row form-row--two">
      <div>
        <label class="form__label" for="categoria_id">Categoría</label>
        <select class="form__select" id="categoria_id" name="categoria_id" required>
          <option value="">Seleccionar categoría</option>
          @foreach($categorias as $cat)
            <option value="{{ $cat['id'] }}"
              {{ ($autoparte && $autoparte['categoria'] === $cat['nombre']) ? 'selected' : '' }}>
              {{ $cat['nombre'] }}
            </option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="form__label" for="marca">Marca</label>
        <input
          class="form__input"
          type="text"
          id="marca"
          name="marca"
          placeholder="Ej. Bosch, NGK, Monroe"
          value="{{ $autoparte['marca'] ?? '' }}"
        >
      </div>
    </div>

    <!-- Precio -->
    <div class="form-row form-row--two">
      <div>
        <label class="form__label" for="precio">Precio (MXN)</label>
        <input
          class="form__input"
          type="number"
          id="precio"
          name="precio"
          step="0.01"
          min="0"
          placeholder="0.00"
          value="{{ $autoparte['precio'] ?? '' }}"
          required
        >
      </div>
      <div>
        <!-- espacio para campos futuros -->
      </div>
    </div>

    <!-- Activo -->
    <div class="form-row">
      <div class="form__checkbox-row">
        <input
          class="form__checkbox"
          type="checkbox"
          id="activo"
          name="activo"
          {{ (!$autoparte || $autoparte['activo']) ? 'checked' : '' }}
        >
        <label class="form__checkbox-label" for="activo">Autoparte activa (visible en el sistema)</label>
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn--primary">
        {{ $modo === 'nueva' ? 'Guardar autoparte' : 'Guardar cambios' }}
      </button>
      <a href="{{ route('autopartes.index') }}" class="btn btn--secondary">Cancelar</a>
    </div>

  </form>
</div>

@endsection
