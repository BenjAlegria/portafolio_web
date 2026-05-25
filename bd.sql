CREATE DATABASE IF NOT EXISTS balegria_db1
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE balegria_db1

-- TABLA: admin_users (Usuarios administradores)
CREATE TABLE IF NOT EXISTS admin_users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50)  NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuario admin por defecto (contraseña: admin123)
INSERT INTO admin_users (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- TABLA: biografia
CREATE TABLE IF NOT EXISTS biografia (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(150) NOT NULL,
    titulo      VARCHAR(200) NOT NULL,
    descripcion TEXT         NOT NULL,
    email       VARCHAR(150),
    github      VARCHAR(255),
    linkedin    VARCHAR(255),
    foto        VARCHAR(255),
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO biografia (nombre, titulo, descripcion, email, github, linkedin) VALUES (
    'Benjamin Ignacio Alegria Barrientos',
    'Estudiante Tec. Informática UCT',
    'Estudiante con formación en modelado de bases de datos, programación y documentación técnica. Me apasiona encontrar soluciones prácticas a problemas tecnológicos y optimizar procesos mediante el uso de herramientas digitales.',
    'balegria2025@alu.uct.cl',
    'https://github.com/BenjAlegria',
);

-- TABLA: habilidades
CREATE TABLE IF NOT EXISTS habilidades (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    icono_html TEXT,
    orden      INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO habilidades (nombre, icono_html, orden) VALUES
('HTML5',      '<i class="bi bi-filetype-html fs-1" style="color:#e34c26"></i>', 1),
('CSS3',       '<i class="bi bi-filetype-css fs-1" style="color:#264de4"></i>',  2),
('JavaScript', '<i class="bi bi-filetype-js fs-1" style="color:#f0db4f"></i>',  3),
('PHP',        '<i class="bi bi-filetype-php fs-1" style="color:#8892be"></i>', 4),
('MySQL',      '<i class="bi bi-database-fill fs-1" style="color:#00758f"></i>',5),
('Bootstrap',  '<i class="bi bi-bootstrap-fill fs-1" style="color:#7952b3"></i>',6),
('GitHub',     '<i class="bi bi-github fs-1" style="color:#24292e"></i>',       7),
('IA Tools',   '<i class="bi bi-robot fs-1" style="color:#10a37f"></i>',        8);

-- TABLA: tecnologias (Nivel actual y enfoque)
CREATE TABLE IF NOT EXISTS tecnologias (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    descripcion TEXT,
    orden       INT DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tecnologias (nombre, descripcion, orden) VALUES
('HTML/CSS',    'Conocimientos básicos, practicando estructura y estilos de páginas web.', 1),
('JavaScript',  'Aprendiendo lógica y funciones simples para interacción en sitios web.', 2),
('PHP',         'Explorando fundamentos para desarrollo backend y proyectos académicos.', 3),
('MySQL',       'Familiarizándome con consultas básicas y modelado de bases de datos.',   4),
('Bootstrap',   'Usando componentes para maquetar páginas responsivas.',                  5),
('Git/GitHub',  'Conociendo el flujo de control de versiones y trabajo colaborativo.',    6),
('React',       'Iniciando en conceptos de componentes y estado, con proyectos pequeños.',7);

-- TABLA: proyectos
CREATE TABLE IF NOT EXISTS proyectos (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    titulo      VARCHAR(200) NOT NULL,
    descripcion TEXT,
    tecnologias VARCHAR(300),
    url_demo    VARCHAR(255),
    url_github  VARCHAR(255),
    imagen      VARCHAR(255),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO proyectos (titulo, descripcion, tecnologias,) VALUES
(
    'Sistema de Gestión Escolar',
    'Aplicación web para gestionar estudiantes, profesores y calificaciones. Desarrollada con PHP, MySQL y Bootstrap.',
    'HTML, CSS, JavaScript, PHP, MySQL, Bootstrap',
    '#', '#'
),
(
    'E-commerce Responsive',
    'Tienda online con carrito de compras, sistema de pagos y panel administrativo. Incluye integración con pasarela de pagos.',
    'HTML, CSS, JavaScript, PHP, MySQL, AJAX',
    '#', '#'
),
(
    'Blog Personal con CMS',
    'Blog con sistema de gestión de contenidos, categorías, comentarios y búsqueda avanzada.',
    'HTML, CSS, JavaScript, PHP, MySQL',
    '#', '#'
);

-- TABLA: contacto (Mensajes recibidos)
CREATE TABLE IF NOT EXISTS contacto (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(150) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    asunto     VARCHAR(200) NOT NULL,
    mensaje    TEXT         NOT NULL,
    leido      TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
