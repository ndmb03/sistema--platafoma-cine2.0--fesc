// --- ARCHIVO: resources/js/admin/pelicula_crud.js ---

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('pelicula-form');
    const messageBox = document.getElementById('message-box');

    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const peliculaId = formData.get('id'); // ID si estamos editando
        
        // Determinar método y URL
        let method = peliculaId ? 'PUT' : 'POST';
        let url = peliculaId 
            ? `/admin/peliculas/${peliculaId}` 
            : '/admin/peliculas';

        // Convertir FormData a JSON
        const data = Object.fromEntries(formData.entries());
        // El método PUT/PATCH requiere simulación en Laravel con el campo _method
        if (peliculaId) {
            data._method = 'PUT';
        }

        // Mostrar mensaje de carga
        showMessage('Guardando película...', 'bg-blue-100 text-blue-700');
        disableForm(true);

        try {
            const response = await fetch(url, {
                method: 'POST', // Siempre POST para incluir el spoofing de PUT/PATCH si aplica
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (response.ok) {
                // Éxito
                showMessage(result.message, 'bg-green-100 text-green-700');
                
                // Si es una creación, podrías redirigir o limpiar el formulario.
                if (!peliculaId) {
                    form.reset();
                }
            } else {
                // Errores de validación o del servidor
                const errors = result.errors || { general: [result.message || 'Error desconocido del servidor.'] };
                displayErrors(errors);
            }

        } catch (error) {
            console.error('Error de red:', error);
            showMessage('Error crítico de conexión.', 'bg-red-100 text-red-700');
        } finally {
            disableForm(false);
        }
    });

    /**
     * Muestra un mensaje al usuario.
     * @param {string} message - Mensaje a mostrar.
     * @param {string} cssClass - Clases de estilo Tailwind.
     */
    function showMessage(message, cssClass) {
        messageBox.textContent = message;
        messageBox.className = `mt-4 p-3 rounded-lg text-center font-semibold ${cssClass}`;
        messageBox.classList.remove('hidden');
    }

    /**
     * Muestra errores de validación.
     * @param {object} errors - Objeto de errores del servidor.
     */
    function displayErrors(errors) {
        let errorHtml = '<ul>';
        // Limpiar errores previos
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

        // Recorrer y mostrar los errores
        for (const [key, messages] of Object.entries(errors)) {
            // Mostrar error bajo el campo correspondiente si existe
            const errorEl = document.getElementById(`error-${key}`);
            if (errorEl) {
                errorEl.textContent = messages.join(' ');
                errorEl.classList.add('text-red-500', 'text-sm');
            } else {
                // Recolectar errores generales
                errorHtml += `<li>${messages.join(' ')}</li>`;
            }
        }
        errorHtml += '</ul>';
        showMessage(`Atención: Por favor corrige los siguientes errores: ${errorHtml}`, 'bg-red-100 text-red-700');
    }

    /**
     * Deshabilita o habilita los campos del formulario.
     * @param {boolean} disabled - Estado de deshabilitación.
     */
    function disableForm(disabled) {
        form.querySelectorAll('input, select, textarea, button').forEach(el => {
            el.disabled = disabled;
        });
        form.querySelector('button[type="submit"]').textContent = disabled ? 'Guardando...' : 'Guardar Película';
    }
});