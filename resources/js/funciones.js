// --- ARCHIVO: resources/js/admin/funcion_crud.js ---

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('funcion-form');
    const messageBox = document.getElementById('message-box');

    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const funcionId = formData.get('id'); 
        
        let method = funcionId ? 'PUT' : 'POST';
        let url = funcionId 
            ? `/admin/funciones/${funcionId}` 
            : '/admin/funciones';

        const data = Object.fromEntries(formData.entries());
        if (funcionId) {
            data._method = 'PUT';
        }
        
        // El input datetime-local a veces requiere formateo o simplemente funciona
        // Laravel debería manejar el formato 'YYYY-MM-DDTHH:MM' directamente

        showMessage('Guardando función...', 'bg-blue-100 text-blue-700');
        disableForm(true);

        try {
            const response = await fetch(url, {
                method: 'POST', 
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (response.ok) {
                showMessage(result.message, 'bg-green-100 text-green-700');
                if (!funcionId) {
                    // Si es creación, podemos limpiar el formulario para la siguiente.
                    form.reset();
                }
            } else {
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
     */
    function showMessage(message, cssClass) {
        messageBox.textContent = message;
        messageBox.className = `mt-4 p-3 rounded-lg text-center font-semibold ${cssClass}`;
        messageBox.classList.remove('hidden');
    }

    /**
     * Muestra errores de validación.
     */
    function displayErrors(errors) {
        let errorHtml = '<ul>';
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

        for (const [key, messages] of Object.entries(errors)) {
            const errorEl = document.getElementById(`error-${key}`);
            if (errorEl) {
                errorEl.textContent = messages.join(' ');
                errorEl.classList.add('text-red-500', 'text-sm');
            } else {
                errorHtml += `<li>${messages.join(' ')}</li>`;
            }
        }
        errorHtml += '</ul>';
        showMessage(`Atención: Por favor corrige los siguientes errores: ${errorHtml}`, 'bg-red-100 text-red-700');
    }

    /**
     * Deshabilita o habilita los campos del formulario.
     */
    function disableForm(disabled) {
        form.querySelectorAll('input, select, button').forEach(el => {
            el.disabled = disabled;
        });
        form.querySelector('button[type="submit"]').textContent = disabled ? 'Guardando...' : 'Guardar Función';
    }
});