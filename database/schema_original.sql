CREATE DATABASE autopartes_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE autopartes_db;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(150)
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_usuarios_roles
        FOREIGN KEY (rol_id)
        REFERENCES roles(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE historial_accesos_anonimos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_origen VARCHAR(45),
    navegador VARCHAR(150),
    fecha_acceso DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mensajes_motivacionales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mensaje VARCHAR(255),
    autor VARCHAR(100)
);


CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(150)
);

CREATE TABLE usuarios_backup (
    id INT,
    nombre VARCHAR(100),
    email VARCHAR(100),
    password_hash VARCHAR(255),
    fecha_respaldo DATETIME
);

CREATE TABLE autopartes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    categoria_id INT NOT NULL,
    marca VARCHAR(100),
    precio DECIMAL(10,2) NOT NULL CHECK (precio >= 0),
    activo BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_autopartes_categorias
        FOREIGN KEY (categoria_id)
        REFERENCES categorias(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE autopartes_temp (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150),
    precio DECIMAL(10,2)
);


CREATE TABLE inventarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    autoparte_id INT NOT NULL UNIQUE,
    stock_actual INT NOT NULL CHECK (stock_actual >= 0),
    stock_minimo INT NOT NULL CHECK (stock_minimo >= 0),
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_inventarios_autopartes
        FOREIGN KEY (autoparte_id)
        REFERENCES autopartes(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE estados_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE estado_pedido_texto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    estado VARCHAR(50)
);


CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    estado_id INT NOT NULL,
    fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL CHECK (total >= 0),
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


CREATE TABLE pedidos_resumen (
    pedido_id INT PRIMARY KEY,
    total_productos INT,
    total_pedido DECIMAL(10,2)
);


CREATE TABLE detalle_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    autoparte_id INT NOT NULL,
    cantidad INT NOT NULL CHECK (cantidad > 0),
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


CREATE TABLE logs_generales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE configuracion_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100),
    valor VARCHAR(255)
);

INSERT INTO estados_pedido (nombre)
VALUES ('CREADO'), ('CONFIRMADO'), ('SURTIDO'), ('ENVIADO'), ('CANCELADO')






