# MACUIN — Plataforma Web de Gestión de Autopartes

Sistema web para una distribuidora de autopartes. Resuelve problemas de duplicación de inventario e inconsistencia de pedidos mediante una arquitectura desacoplada en tres componentes.

**Universidad Politécnica de Querétaro — Tecnologías y Aplicaciones en Internet**

---

## Arquitectura

```
                    ┌─────────────────────┐
                    │   API Central        │
                    │   FastAPI (Python)   │
                    │   Puerto: 8000       │
                    └──────────┬──────────┘
                               │
              ┌────────────────┼────────────────┐
              │                                  │
   ┌──────────▼──────────┐          ┌───────────▼───────────┐
   │  Cliente Interno    │          │  Cliente Externo       │
   │  Flask (Python)     │          │  Laravel (PHP)         │
   │  Puerto: 5000       │          │  Puerto: 8080          │
   └─────────────────────┘          └───────────────────────┘
                               │
                    ┌──────────▼──────────┐
                    │   MySQL 8.0          │
                    │   Puerto: 3306       │
                    └─────────────────────┘
```

| Componente       | Tecnología | Versión  |
|------------------|------------|----------|
| Cliente interno  | Flask      | 3.0.0    |
| Cliente externo  | Laravel    | 10.x     |
| API central      | FastAPI    | TBD      |
| Base de datos    | MySQL      | 8.0      |
| Interfaz BD      | phpMyAdmin | latest   |
| Contenedores     | Docker + Compose | latest |

---

## Requisitos

Solo se requiere tener instalados:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (incluye Docker Compose)

No se necesitan entornos virtuales de Python, gestores de paquetes locales ni ninguna otra dependencia. Todo el stack corre dentro de contenedores Docker.

---

## Configuración inicial

**1. Clonar el repositorio**

```bash
git clone <url-del-repositorio>
cd macuin
```

**2. Crear el archivo de variables de entorno**

```bash
cp .env.example .env
```

Abrir `.env` y completar los valores requeridos:

```
MYSQL_ROOT_PASSWORD=tu_contraseña_root
MYSQL_DATABASE=autopartes_db
MYSQL_USER=tu_usuario
MYSQL_PASSWORD=tu_contraseña
FLASK_ENV=development
SECRET_KEY=clave_secreta_larga_y_aleatoria
```

Los valores de puerto (`FLASK_PORT`, `PHPMYADMIN_PORT`) tienen valores por defecto y son opcionales.

**3. Levantar los servicios**

```bash
docker-compose up --build
```

---

## Acceso a los servicios

| Servicio       | URL                            | Descripción                     |
|----------------|--------------------------------|---------------------------------|
| Flask (admin)  | http://localhost:5000          | Panel interno (ventas, almacén) |
| phpMyAdmin     | http://localhost:8081          | Interfaz web para MySQL         |
| MySQL          | localhost:3306                 | Conexión directa a la BD        |

El puerto del panel Flask y de phpMyAdmin pueden ajustarse en `.env` mediante `FLASK_PORT` y `PHPMYADMIN_PORT`.

---

## Comandos frecuentes

```bash
# Levantar todos los servicios (con rebuild)
docker-compose up --build

# Levantar en segundo plano
docker-compose up -d --build

# Detener todos los servicios
docker-compose down

# Detener y eliminar volúmenes (reinicia la base de datos)
docker-compose down -v

# Ver logs del servicio Flask
docker-compose logs flask

# Ver logs de MySQL
docker-compose logs db

# Reconstruir solo el contenedor de Flask
docker-compose up --build flask

# Acceder a MySQL directamente dentro del contenedor
docker exec -it macuin_db mysql -u root -p
```

---

## Estructura del proyecto

```
macuin/
├── README.md                      # Este archivo
├── docker-compose.yml             # Definición de todos los servicios
├── .env.example                   # Plantilla de variables de entorno
├── .gitignore
├── database/
│   ├── schema_clean.sql           # Esquema activo (usar este)
│   └── schema_original.sql        # Referencia original (no modificar)
├── docs/
│   ├── assets/                    # Recursos visuales
│   └── diagrams/                  # Diagramas de arquitectura y ER
├── flask_app/
│   ├── Dockerfile
│   ├── requirements.txt
│   ├── app.py
│   ├── static/css/style.css
│   └── templates/
│       ├── base.html
│       ├── auth/login.html
│       ├── autopartes/lista.html
│       ├── autopartes/formulario.html
│       ├── inventarios/lista.html
│       ├── pedidos/lista.html
│       └── pedidos/detalle.html
└── laravel_app/                   # Reservado para entregable futuro
```

---

## Base de datos

### Tablas principales

| Tabla            | Descripción                                    |
|------------------|------------------------------------------------|
| `roles`          | Catálogo de roles de usuario                   |
| `usuarios`       | Usuarios del sistema (interno y externo)       |
| `categorias`     | Clasificación de autopartes                    |
| `autopartes`     | Catálogo de productos                          |
| `inventarios`    | Stock por autoparte (relación 1:1)             |
| `estados_pedido` | Ciclo de vida de un pedido                     |
| `pedidos`        | Pedidos generados por usuarios                 |
| `detalle_pedido` | Líneas de producto dentro de cada pedido       |

### Datos precargados

La tabla `estados_pedido` se inicializa automáticamente con: `CREADO`, `CONFIRMADO`, `SURTIDO`, `ENVIADO`, `CANCELADO`.

El esquema se aplica al contenedor de MySQL en el primer arranque mediante `docker-entrypoint-initdb.d`.

---

## Alcance del entregable actual

- Cliente interno Flask: plantillas estáticas con datos de demostración (sin consultas reales a BD)
- Esquema MySQL completo y depurado
- Infraestructura Docker funcional
- Repositorio configurado

No está implementado aún: API central (FastAPI), autenticación real, cliente externo (Laravel).

---

## Equipo

| Nombre                          | Rol         |
|---------------------------------|-------------|
| Artemio Hurtado Hernández       | Desarrollador |
| María Guadalupe Jiménez Ruiz    | Desarrolladora |
| Diego Antonio García García     | Desarrollador |
| Emiliano Ledesma Ledesma        | Desarrollador |

**Profesor:** Iván Isay Guerra López
**Institución:** Universidad Politécnica de Querétaro — S204
**Materia:** Tecnologías y Aplicaciones en Internet
