/* ===========================
   PORTAFOLIO - main.js
   Benjamin Alegria
=========================== */

document.addEventListener('DOMContentLoaded', function () {

    // ── 1. NAVBAR: marcar enlace activo según scroll ──
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');

    function updateActiveNav() {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            if (window.scrollY >= sectionTop) {
                current = section.getAttribute('id');
            }
        });
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', updateActiveNav);
    updateActiveNav();

    // ── 2. ANIMACIONES fade-up al hacer scroll ──
    const fadeElements = document.querySelectorAll('.skill-card, .tech-card, .project-card');

    fadeElements.forEach(el => el.classList.add('fade-up'));

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, index * 60);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    fadeElements.forEach(el => observer.observe(el));

    // ── 3. FORMULARIO DE CONTACTO con AJAX ──
    const btnEnviar = document.getElementById('btnEnviar');

    if (btnEnviar) {
        btnEnviar.addEventListener('click', function () {
            const nombre  = document.getElementById('contactNombre').value.trim();
            const email   = document.getElementById('contactEmail').value.trim();
            const asunto  = document.getElementById('contactAsunto').value.trim();
            const mensaje = document.getElementById('contactMensaje').value.trim();
            const alertDiv = document.getElementById('alertContacto');

            // Validación básica
            if (!nombre || !email || !asunto || !mensaje) {
                showAlert(alertDiv, 'danger', 'Por favor completa todos los campos.');
                return;
            }

            if (!isValidEmail(email)) {
                showAlert(alertDiv, 'danger', 'Por favor ingresa un correo válido.');
                return;
            }

            // Estado cargando
            btnEnviar.disabled = true;
            btnEnviar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

            // AJAX request
            fetch('api/contacto.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, email, asunto, mensaje })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showAlert(alertDiv, 'success', '¡Mensaje enviado correctamente! Te responderé pronto.');
                    // Limpiar campos
                    ['contactNombre','contactEmail','contactAsunto','contactMensaje']
                        .forEach(id => document.getElementById(id).value = '');
                } else {
                    showAlert(alertDiv, 'danger', data.message || 'Error al enviar el mensaje.');
                }
            })
            .catch(() => {
                showAlert(alertDiv, 'danger', 'Error de conexión. Intenta nuevamente.');
            })
            .finally(() => {
                btnEnviar.disabled = false;
                btnEnviar.innerHTML = '<i class="bi bi-envelope me-2"></i>Enviar Mensaje';
            });
        });
    }

    // ── Helpers ──
    function showAlert(container, type, message) {
        const icons = { success: 'bi-check-circle-fill', danger: 'bi-exclamation-circle-fill' };
        container.innerHTML = `
            <div class="alert alert-${type} d-flex align-items-center gap-2 rounded-3 mb-4" role="alert">
                <i class="bi ${icons[type]}"></i>
                <span>${message}</span>
            </div>`;
        container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        setTimeout(() => { container.innerHTML = ''; }, 5000);
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // ── 4. Cerrar navbar mobile al hacer click en un enlace ──
    const navCollapse = document.getElementById('navbarNav');
    if (navCollapse) {
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
                if (bsCollapse) bsCollapse.hide();
            });
        });
    }

});
