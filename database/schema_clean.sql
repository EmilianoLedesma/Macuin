-- =============================================================
-- MACUIN — Plataforma Web de Gestión de Autopartes
-- Schema limpio y depurado
-- Tablas eliminadas respecto al original:
--   usuarios_backup     — respaldo manual sin uso funcional
--   autopartes_temp     — tabla temporal sin relaciones
--   estado_pedido_texto — duplica estados_pedido sin FK
--   pedidos_resumen     — datos calculables, no deben persistirse
--   historial_accesos_anonimos — fuera del alcance del entregable
--   mensajes_motivacionales   — sin relación con el negocio
--   logs_generales            — sin estructura útil ni relaciones
--   configuracion_sistema     — sin uso en el esquema actual
-- =============================================================

CREATE DATABASE IF NOT EXISTS autopartes_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE autopartes_db;

-- -------------------------------------------------------------
-- roles
-- Catálogo de roles de usuario (interno, externo, admin…)
-- -------------------------------------------------------------
CREATE TABLE roles (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(50)  NOT NULL UNIQUE,
    descripcion VARCHAR(150)
);

-- -------------------------------------------------------------
-- usuarios
-- Usuarios del sistema: personal interno y clientes externos
-- -------------------------------------------------------------
CREATE TABLE usuarios (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(100) NOT NULL,
    email           VARCHAR(100) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    rol_id          INT          NOT NULL,
    fecha_registro  DATETIME     DEFAULT CURRENT_TIMESTAMP,
    activo          BOOLEAN      DEFAULT TRUE,
    CONSTRAINT fk_usuarios_roles
        FOREIGN KEY (rol_id)
        REFERENCES roles(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- -------------------------------------------------------------
-- categorias
-- Clasificación de autopartes (Motor, Frenos, Suspensión…)
-- -------------------------------------------------------------
CREATE TABLE categorias (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(150)
);

-- -------------------------------------------------------------
-- autopartes
-- Catálogo de productos disponibles para venta
-- -------------------------------------------------------------
CREATE TABLE autopartes (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(150) NOT NULL,
    descripcion  TEXT,
    categoria_id INT          NOT NULL,
    marca        VARCHAR(100),
    precio       DECIMAL(10,2) NOT NULL CHECK (precio >= 0),
    activo       BOOLEAN       DEFAULT TRUE,
    CONSTRAINT fk_autopartes_categorias
        FOREIGN KEY (categoria_id)
        REFERENCES categorias(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- -------------------------------------------------------------
-- inventarios
-- Stock actual y mínimo por autoparte (relación 1:1)
-- -------------------------------------------------------------
CREATE TABLE inventarios (
    id                   INT AUTO_INCREMENT PRIMARY KEY,
    autoparte_id         INT NOT NULL UNIQUE,
    stock_actual         INT NOT NULL CHECK (stock_actual >= 0),
    stock_minimo         INT NOT NULL CHECK (stock_minimo >= 0),
    fecha_actualizacion  DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_inventarios_autopartes
        FOREIGN KEY (autoparte_id)
        REFERENCES autopartes(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- -------------------------------------------------------------
-- estados_pedido
-- Catálogo de estados del ciclo de vida de un pedido
-- -------------------------------------------------------------
CREATE TABLE estados_pedido (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- -------------------------------------------------------------
-- pedidos
-- Pedidos generados por usuarios del sistema
-- -------------------------------------------------------------
CREATE TABLE pedidos (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id   INT           NOT NULL,
    estado_id    INT           NOT NULL,
    fecha_pedido DATETIME      DEFAULT CURRENT_TIMESTAMP,
    total        DECIMAL(10,2) NOT NULL CHECK (total >= 0),
    CONSTRAINT fk_pedidos_usuarios
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_pedidos_estados
        FOREIGN KEY (estado_id)
        REFERENCES estados_pedido(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- -------------------------------------------------------------
-- detalle_pedido
-- Líneas de producto dentro de cada pedido
-- -------------------------------------------------------------
CREATE TABLE detalle_pedido (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id       INT           NOT NULL,
    autoparte_id    INT           NOT NULL,
    cantidad        INT           NOT NULL CHECK (cantidad > 0),
    precio_unitario DECIMAL(10,2) NOT NULL CHECK (precio_unitario >= 0),
    CONSTRAINT fk_detalle_pedido_pedidos
        FOREIGN KEY (pedido_id)
        REFERENCES pedidos(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_detalle_pedido_autopartes
        FOREIGN KEY (autoparte_id)
        REFERENCES autopartes(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT uk_pedido_autoparte UNIQUE (pedido_id, autoparte_id)
);

-- -------------------------------------------------------------
-- Seed data
-- -------------------------------------------------------------
INSERT INTO estados_pedido (nombre)
VALUES ('CREADO'), ('CONFIRMADO'), ('SURTIDO'), ('ENVIADO'), ('CANCELADO');
