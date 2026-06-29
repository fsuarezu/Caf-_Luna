--Lucas Leiva
--Fabian Suárez

CREATE DATABASE IF NOT EXISTS cafe_luna;
USE cafe_luna;

-- Tabla de usuarios administradores
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(100) NOT NULL,
    contrasenia VARCHAR(255) NOT NULL,
    rol VARCHAR(20) DEFAULT 'admin'
);

-- Tabla de tokens para recordar sesión y recuperación de contraseña
CREATE TABLE token (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expiracion DATETIME NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

-- Tabla de categorías de productos
CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Tabla de métodos de pago
CREATE TABLE metodo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre CHAR(8) NOT NULL
);

-- Tabla de estados de pedido
CREATE TABLE estado_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL
);

-- Tabla de productos
CREATE TABLE producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio INT NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id)
);

-- Tabla de carrito
CREATE TABLE carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    FOREIGN KEY (producto_id) REFERENCES producto(id)
);

-- Tabla de pedidos
CREATE TABLE pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    id_metodo INT NOT NULL,
    productos TEXT NOT NULL,
    total INT NOT NULL,
    id_estado INT NOT NULL DEFAULT 1,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_metodo) REFERENCES metodo(id),
    FOREIGN KEY (id_estado) REFERENCES estado_pedido(id)
);

-- Datos iniciales: categorías
INSERT INTO categoria (nombre) VALUES
('Cafés y Especialidades'),
('Sándwiches y Salados'),
('Repostería y Dulces'),
('Bebidas Frías');

-- Datos iniciales: métodos de pago
INSERT INTO metodo (nombre) VALUES
('credito'),
('debito');

-- Datos iniciales: estados de pedido
INSERT INTO estado_pedido (nombre) VALUES
('pendiente'),
('listo'),
('entregado');

-- Datos iniciales: productos
INSERT INTO producto (nombre, precio, id_categoria) VALUES
('Espresso', 1800, 1),
('Americano', 2000, 1),
('Cappuccino', 2500, 1),
('Latte Clásico', 2800, 1),
('French Vanilla', 3000, 1),
('Caramel Macchiato', 3500, 1),
('Pumpkin Spice Latte', 3800, 1),
('Avellana', 3200, 1),
('Mocha', 3500, 1),
('Tostadas con Palta', 3500, 2),
('Sándwich Ave Palta', 4500, 2),
('Sándwich Barros Jarpa', 4200, 2),
('Quiche de Espinaca y Champiñón', 3800, 2),
('Empanaditas de Queso (x3)', 2500, 2),
('Kuchen de Nuez', 3200, 3),
('Kuchen de Frambuesa', 3000, 3),
('Pie de Limón', 2800, 3),
('Alfajor de Manjar Casero', 1500, 3),
('Muffin de Arándanos', 2000, 3),
('Medialunas (x2)', 2200, 3),
('Croissant de Mantequilla', 2000, 3),
('Iced Americano', 2500, 4),
('Frappuccino de Caramelo', 4500, 4),
('Jugo Natural de Frambuesa', 3000, 4),
('Limonada Menta Jengibre', 2800, 4);

-- Usuario administrador (contraseña: admin1234)
INSERT INTO usuario (correo, contrasenia, rol) VALUES
('admin@cafeluna.cl', '$2y$10$FEyUBX39qvOHv/WRX6tzquTjj5MZnEkVuH.eo/ESzCeDKzcQQdiha', 'admin');

-- Usuario cajero (contraseña: admin1234)
INSERT INTO usuario (correo, contrasenia, rol) VALUES
('caja@cafeluna.cl', '$2y$10$FEyUBX39qvOHv/WRX6tzquTjj5MZnEkVuH.eo/ESzCeDKzcQQdiha', 'caja');