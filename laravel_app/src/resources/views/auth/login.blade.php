<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión — MACUIN</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="login-page">
  <div class="login-card">

    <div class="login-card__header">
      <div class="login-card__logo">MACUIN</div>
      <div class="login-card__subtitle">Autopartes y Distribución</div>
    </div>

    <div class="login-card__body">
      <h2 class="login-card__title">Acceso al panel interno</h2>

      @if(session('error'))
        <div class="login-card__error">{{ session('error') }}</div>
      @endif

      <!-- Datos mockeados: cualquier correo y contraseña funciona en producción real -->
      <!-- Demo: admin@macuin.mx / 12345 -->
      <form method="post" action="#">

        <div class="form-row">
          <label class="form__label" for="email">Correo electrónico</label>
          <input
            class="form__input"
            type="email"
            id="email"
            name="email"
            placeholder="usuario@macuin.mx"
            autocomplete="email"
            required
          >
        </div>

        <div class="form-row">
          <label class="form__label" for="password">Contraseña</label>
          <input
            class="form__input"
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
            autocomplete="current-password"
            required
          >
        </div>

        <div class="login-card__footer">
          <label class="login-card__remember">
            <input type="checkbox" name="remember"> Recuérdame
          </label>
          <a href="#" class="login-card__forgot">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="login-card__btn">Iniciar sesión</button>

      </form>
    </div>

  </div>
</div>

</body>
</html>
