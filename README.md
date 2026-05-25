# 🚀 Portafolio Web Profesional — Benjamin Alegria

> Evaluación N°3 — Desarrollo Web | Tec. Informática UCT

## 🔗 Proyecto en Producción

**[https://teclab.uct.cl/~balegria2025/portafolio/index.php](https://teclab.uct.cl/~balegria2025portafolio/index.php)**

## 📋 Descripción

Portafolio web profesional autoadministrable desarrollado con PHP, MySQL, Bootstrap 5 y JavaScript. Permite presentar información profesional de forma dinámica con un panel de administración protegido.

## 🛠️ Tecnologías Utilizadas

| Tecnología | Uso |
|---|---|
| HTML5 | Estructura semántica |
| CSS3 | Estilos personalizados |
| Bootstrap 5.3.8 | Framework CSS responsive |
| JavaScript | Interactividad y AJAX |
| PHP | Backend y lógica del servidor |
| MySQL | Base de datos |
| AJAX + JSON | Formulario de contacto dinámico |

## 📁 Estructura del Proyecto

```
portafolio/
├── index.php              # Página principal pública
├── login.php              # Inicio de sesión admin
├── bd.sql                 # Script base de datos
├── README.md
├── assets/
│   ├── css/style.css      # Estilos principales
│   ├── js/script.js       # JavaScript principal
│   └── img/               # Imágenes del proyecto
├── includes/
│   ├── db.php             # Conexión PDO a MySQL
│   ├── functions.php      # Funciones reutilizables
│   └── auth.php           # Protección de sesión
├── dashboard/
│   ├── index.php          # Panel administrador
│   ├── biografia.php      # Editar biografía
│   ├── habilidades.php    # CRUD habilidades
│   ├── tecnologias.php    # CRUD tecnologías
│   ├── proyectos.php      # CRUD proyectos
│   ├── mensajes.php       # Ver mensajes contacto
│   └── logout.php
└── api/
    └── contacto.php       # Endpoint AJAX contacto
```

## ⚙️ Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/BenjAlegria/portafolio_web.git
```

### 2. Crear la base de datos
```bash
mysql -u root -p < bd.sql
```

### 3. Configurar conexión BD
Edita `includes/db.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'portafolio_db');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
```

### 4. Acceso al panel admin
- **URL:** `/login.php`
- **Usuario:** `admin`
- **Contraseña:** `admin123`

> ⚠️ Cambia las credenciales en producción

## ✨ Funcionalidades

- ✅ Navbar responsive con scroll activo
- ✅ Sección de Biografía dinámica
- ✅ Grid de Habilidades y Herramientas
- ✅ Sección Tecnologías con tarjetas
- ✅ Portafolio de Proyectos (CRUD)
- ✅ Formulario de Contacto con AJAX
- ✅ Sistema de Login con sesiones PHP
- ✅ Dashboard Administrativo completo
- ✅ Diseño 100% Responsive (Mobile-first)

## 🤖 Herramientas de IA Utilizadas

Ver documento `uso-ia.md` para detalle completo de:
- Herramientas utilizadas (Claude, ChatGPT, GitHub Copilot)
- Prompts empleados
- Resultados generados
- Ajustes realizados
- Reflexión crítica

## 📐 Diseño

El proyecto fue desarrollado en base al wireframe diseñado en **Figma**.
[Ver diseño en Figma](https://www.figma.com/make/GWD81zJlmN3wp3Q5pvQL3l/Diseñar-wireframe-portafolio-web?p=f&t=Baomd5WGEgXiDcTh-0/)

---

**Autor:** Benjamin Ignacio Alegria Barrientos  
**Institución:** Universidad Católica de Temuco — Tec. Informática
