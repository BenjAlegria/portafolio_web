# 🤖 Documentación de Uso de Inteligencia Artificial

**Proyecto:** Portafolio Web Profesional Autoadministrable  
**Estudiante:** Benjamin Ignacio Alegria Barrientos  
**Evaluación:** N°3 — Desarrollo Web | Tec. Informática UCT

---

## 1. Herramientas de IA Utilizadas

| Herramienta | Propósito |
|---|---|
| **Claude (Anthropic)** | Generación de estructura HTML, CSS, PHP y consultas SQL |
| **ChatGPT (OpenAI)** | Resolución de dudas puntuales sobre JavaScript y AJAX |
| **GitHub Copilot** | Autocompletado de código durante el desarrollo en VSCode |

---

## 2. Prompts Utilizados

### Prompt 1 — Estructura inicial del proyecto
```
Ayúdame a crear la estructura de carpetas y archivos para un portafolio 
web en PHP con: página principal, login, dashboard administrativo y 
conexión a MySQL con PDO. Incluye buenas prácticas de organización.
```

**Resultado obtenido:**  
Estructura de carpetas completa con separación de concerns: `includes/`, `dashboard/`, `api/`, `assets/`.

---

### Prompt 2 — Diseño CSS fiel al wireframe
```
Tengo un wireframe minimalista blanco con navbar centrado, secciones 
con fondo alternado blanco/gris claro, tarjetas con bordes suaves y 
footer oscuro. Genera CSS con variables para replicar este diseño 
usando Bootstrap 5 como base.
```

**Resultado obtenido:**  
Sistema de variables CSS con colores del wireframe, estilos para `.skill-card`, `.tech-card`, `.project-card` y footer oscuro.

---

### Prompt 3 — Formulario de contacto con AJAX
```
Crea un endpoint PHP (api/contacto.php) que reciba datos JSON vía POST,
valide nombre, email, asunto y mensaje, guarde en tabla MySQL, y retorne
JSON con success/error. También el JavaScript fetch() correspondiente.
```

**Resultado obtenido:**  
Archivo `api/contacto.php` con validaciones y `main.js` con la función `fetch()` y manejo de errores.

---

### Prompt 4 — Script SQL completo
```
Genera el script SQL completo para una base de datos de portafolio web con tablas:
admin_users, biografia, habilidades, tecnologias, proyectos, contacto.
Incluye datos de ejemplo y hash de contraseña para usuario admin.
```

**Resultado obtenido:**  
Archivo `bd.sql` con todas las tablas, relaciones, datos por defecto y usuario admin con contraseña hasheada.

---

### Prompt 5 — Dashboard administrativo
```
Crea un dashboard PHP con sidebar lateral oscuro y contenido principal,
que tenga CRUD para: proyectos (con subida de imágenes), habilidades y
tecnologías. Usa Bootstrap 5, sesiones PHP para protección y modal para
formularios de creación.
```

**Resultado obtenido:**  
Páginas de dashboard con sidebar, tablas de datos, modales Bootstrap para crear/editar, y protección mediante `requireLogin()`.

---

## 3. Resultados Generados

### Código generado y utilizado:
- Estructura completa de carpetas del proyecto
- `style.css` — sistema de variables CSS y estilos por componente
- `bd.sql` — script completo con 6 tablas y datos de prueba
- `api/contacto.php` — endpoint AJAX con validaciones
- `dashboard/proyectos.php` — CRUD completo con subida de imágenes

### Ideas y estructuras obtenidas:
- Patrón de organización con `includes/` para funciones reutilizables
- Uso de PDO con prepared statements para seguridad
- Sistema de fallback cuando la BD no está disponible

---

## 4. Ajustes Realizados

Las respuestas de la IA fueron puntos de partida que requirieron modificaciones:

| Aspecto | Ajuste Realizado |
|---|---|
| **CSS** | Se ajustaron los colores y tipografías para coincidir con el wireframe de Figma |
| **PHP** | Se agregó sistema de fallback con datos por defecto cuando la BD no conecta |
| **JavaScript** | Se modificó el manejo de errores AJAX y se agregaron las animaciones IntersectionObserver |
| **SQL** | Se personalizaron los datos de ejemplo con información real del portafolio |
| **Dashboard** | Se reorganizó la navegación del sidebar y se corrigieron rutas relativas |
| **Seguridad** | Se revisaron todos los `htmlspecialchars()` y se verificaron las sanitizaciones |

---

## 5. Reflexión Crítica

### ✅ Utilidad
La IA fue extremadamente útil para **acelerar la generación de código repetitivo** como formularios, tablas CRUD y configuración inicial. Lo que habría tomado horas se redujo a minutos en las partes estructurales.

### ✅ Ventajas
- Genera código funcional rápidamente como base de trabajo
- Sugiere mejores prácticas (prepared statements, separación de concerns)
- Ayuda a recordar sintaxis exacta de funciones PHP/MySQL
- Útil para depurar errores al explicarle el problema

### ⚠️ Limitaciones
- El código generado **no conoce el contexto específico del proyecto** y requiere adaptación
- A veces genera código **desactualizado o con errores sutiles** que deben verificarse
- No puede replicar fielmente un diseño visual sin una descripción muy detallada
- Puede generar código inseguro si no se especifican los requisitos de seguridad

### 📚 Aprendizaje Obtenido
El uso de IA me permitió enfocarse en **comprender la lógica** del proyecto en lugar de memorizar sintaxis. Al revisar y ajustar el código generado, desarrollé una comprensión más profunda de:
- Cómo funciona PDO y por qué es más seguro que mysqli
- La importancia de sanitizar datos tanto en frontend como en backend
- El patrón AJAX + JSON para comunicación asíncrona
- Cómo organizar un proyecto PHP de manera escalable

**Conclusión:** La IA es una herramienta de apoyo poderosa que **amplifica la productividad**, pero no reemplaza la comprensión técnica. Cada línea de código generada debe ser revisada, comprendida y adaptada por el desarrollador.

---

*Documento preparado para la Evaluación N°3 — Desarrollo Web*  
*Universidad Católica de Temuco — Tec. Informática — 2025*
