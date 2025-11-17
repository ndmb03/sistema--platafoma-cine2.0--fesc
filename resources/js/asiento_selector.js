// --- ARCHIVO: resources/js/asiento_selector.js (Requiere compilación con Vite/Mix) ---

// Definición de constantes y variables globales
const seatMapContainer = document.getElementById('seat-map');
const selectedCountEl = document.getElementById('selected-count');
const totalPriceEl = document.getElementById('total-price');
const selectedSeatsListEl = document.getElementById('selected-seats-list');
const buyButton = document.getElementById('buy-button');
const messageBox = document.getElementById('message-box');

const funcionId = document.getElementById('funcion-id').value;
const basePrice = parseFloat(document.getElementById('base-price').value);
const salaCapacidad = parseInt(document.getElementById('sala-capacidad').value);
const csrfToken = document.getElementById('csrf-token').value;

let selectedSeats = []; // Almacena objetos {fila: 'A', numero: 1}
let occupiedSeats = []; // Almacena objetos {fila: 'A', asiento_numero: 1}

// --- LÓGICA PRINCIPAL ---

document.addEventListener('DOMContentLoaded', () => {
    // 1. Obtener asientos ocupados al cargar
    fetchOccupiedSeats();

    // 2. Asignar evento al botón de compra
    buyButton.addEventListener('click', handlePurchase);
});

/**
 * Función para obtener los asientos ya vendidos de la API.
 */
async function fetchOccupiedSeats() {
    try {
        showMessage('Cargando disponibilidad de asientos...', 'bg-blue-100 text-blue-700');
        const response = await fetch(`/boletos/ocupados/${funcionId}`);
        
        if (!response.ok) {
            throw new Error('Error al obtener asientos ocupados. Estado: ' + response.status);
        }

        const data = await response.json();
        
        // Guardamos los asientos ocupados
        occupiedSeats = data.asientos_ocupados.map(a => ({
            fila: a.fila, 
            numero: a.asiento_numero // Renombramos 'asiento_numero' a 'numero' para consistencia
        })); 

        // 2. Una vez cargados, renderizamos el mapa.
        renderSeatMap(data.sala_capacidad);
        showMessage('Asientos disponibles. Haz click para seleccionar.', 'bg-green-100 text-green-700');

    } catch (error) {
        console.error('Error al cargar el mapa de asientos:', error);
        showMessage('Error al cargar la sala. Inténtalo de nuevo.', 'bg-red-100 text-red-700');
        // Deshabilitar la compra si hay error crítico de carga
        buyButton.disabled = true;
    }
}

/**
 * Dibuja el mapa de asientos basado en la capacidad total de la sala.
 * @param {number} totalCapacity - Capacidad total de la sala.
 */
function renderSeatMap(totalCapacity) {
    // Definimos la lógica de filas/columnas. Ejemplo: 10 filas, 10 asientos por fila.
    // Esto es simplificado, en un sistema real, la sala tendría un layout definido.
    const seatsPerRow = 15; 
    const totalRows = Math.ceil(totalCapacity / seatsPerRow);
    
    // Generar nombres de filas (A, B, C...)
    const rowNames = Array.from({length: totalRows}, (_, i) => String.fromCharCode(65 + i));
    
    let html = '';
    
    html += '<div class="flex flex-col items-center space-y-2 select-none">';
    
    rowNames.forEach((rowName, rowIndex) => {
        html += `<div class="flex items-center space-x-2" data-row="${rowName}">`;
        
        // Etiqueta de la fila a la izquierda
        html += `<span class="w-6 text-center font-bold text-gray-500 mr-2">${rowName}</span>`;

        for (let i = 1; i <= seatsPerRow; i++) {
            const seat = { fila: rowName, numero: i };
            
            // Si la capacidad total ya se superó, es un asiento "virtual" no seleccionable
            if (rowIndex * seatsPerRow + i > totalCapacity) {
                html += `<div class="w-6 h-6 bg-gray-300 rounded-md cursor-not-allowed shadow-sm border border-gray-400"></div>`;
                continue;
            }

            const isOccupied = occupiedSeats.some(a => a.fila === rowName && a.numero === i);
            const statusClass = isOccupied ? 'bg-red-600 cursor-not-allowed' : 'bg-green-500 cursor-pointer hover:bg-green-600 transition duration-150';
            const dataAttributes = `data-fila="${rowName}" data-numero="${i}"`;
            const disabled = isOccupied ? 'disabled' : '';

            // Renderizar el asiento
            html += `
                <div ${dataAttributes} ${disabled} 
                     class="seat-element w-6 h-6 rounded-md shadow-md border border-gray-400 flex items-center justify-center text-xs text-white font-bold ${statusClass}">
                    <!-- ${i} -->
                </div>
            `;
        }
        
        // Etiqueta de la fila a la derecha
        html += `<span class="w-6 text-center font-bold text-gray-500 ml-2">${rowName}</span>`;

        html += `</div>`;
    });
    
    html += '</div>';
    
    // Reemplazar el mensaje de carga con el mapa
    seatMapContainer.innerHTML = html;
    
    // Asignar el listener de click a todos los asientos disponibles
    document.querySelectorAll('.seat-element:not([disabled])').forEach(seatEl => {
        seatEl.addEventListener('click', toggleSeatSelection);
    });
}

/**
 * Maneja la selección/deselección de un asiento.
 * @param {Event} e - Evento de click.
 */
function toggleSeatSelection(e) {
    const seatEl = e.currentTarget;
    const fila = seatEl.dataset.fila;
    const numero = parseInt(seatEl.dataset.numero);
    const seatId = `${fila}-${numero}`;
    
    // Buscar si ya está seleccionado
    const index = selectedSeats.findIndex(seat => seat.fila === fila && seat.numero === numero);

    if (index === -1) {
        // Seleccionar asiento
        selectedSeats.push({ fila, numero });
        seatEl.classList.remove('bg-green-500', 'hover:bg-green-600');
        seatEl.classList.add('bg-yellow-500');
    } else {
        // Deseleccionar asiento
        selectedSeats.splice(index, 1);
        seatEl.classList.remove('bg-yellow-500');
        seatEl.classList.add('bg-green-500', 'hover:bg-green-600');
    }

    updateSummary();
}

/**
 * Actualiza el resumen de la compra (contador, total y lista).
 */
function updateSummary() {
    // Actualizar Contador
    selectedCountEl.textContent = selectedSeats.length;

    // Actualizar Precio Total
    const totalPrice = selectedSeats.length * basePrice;
    totalPriceEl.textContent = `$${totalPrice.toFixed(2)}`;
    
    // Actualizar Botón de Compra
    buyButton.disabled = selectedSeats.length === 0;

    // Actualizar Lista de Asientos
    if (selectedSeats.length === 0) {
        selectedSeatsListEl.innerHTML = '<li class="text-gray-500" id="empty-list-message">Ningún asiento seleccionado.</li>';
    } else {
        selectedSeats.sort((a, b) => {
            if (a.fila < b.fila) return -1;
            if (a.fila > b.fila) return 1;
            return a.numero - b.numero;
        });
        
        selectedSeatsListEl.innerHTML = selectedSeats.map(seat => 
            `<li class="font-medium text-gray-800">${seat.fila}-${seat.numero}</li>`
        ).join('');
    }
}

/**
 * Muestra un mensaje temporal al usuario.
 * @param {string} message - El mensaje a mostrar.
 * @param {string} cssClass - Clases de Tailwind para el estilo (ej. 'bg-green-100 text-green-700').
 */
function showMessage(message, cssClass) {
    messageBox.textContent = message;
    messageBox.className = `mt-4 p-3 rounded-lg text-center font-semibold ${cssClass}`;
    messageBox.classList.remove('hidden');
    // Ocultar después de 5 segundos si no es un error
    if (!cssClass.includes('red')) {
         setTimeout(() => { messageBox.classList.add('hidden'); }, 5000);
    }
}

/**
 * Maneja la lógica de compra (POST a la API de boletos).
 */
async function handlePurchase() {
    if (selectedSeats.length === 0) {
        showMessage('Debes seleccionar al menos un asiento.', 'bg-yellow-100 text-yellow-700');
        return;
    }

    buyButton.disabled = true;
    buyButton.textContent = 'Procesando compra...';
    showMessage('Enviando pedido...', 'bg-indigo-100 text-indigo-700');

    try {
        const payload = {
            funcion_id: funcionId,
            // Aquí puedes añadir el user_id si el usuario está autenticado, 
            // de lo contrario, se enviará null y Laravel lo manejará.
            // user_id: USER_ID_AQUI, 
            asientos_seleccionados: selectedSeats.map(a => ({
                fila: a.fila, 
                numero: a.numero
            })),
            _token: csrfToken // Incluir el CSRF token
        };

        const response = await fetch('/boletos/comprar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken 
            },
            body: JSON.stringify(payload),
        });

        const result = await response.json();

        if (response.ok) {
            // Éxito: limpiar selección, actualizar mapa
            showMessage(result.message, 'bg-green-100 text-green-700');
            selectedSeats = [];
            updateSummary();
            fetchOccupiedSeats(); // Recargar el mapa para ver los asientos recién comprados como ocupados.
        } else {
            // Error de validación o conflicto (ej. asiento ya vendido)
            const errorMessage = result.message || (result.errors?.asientos_seleccionados?.[0]) || 'Error desconocido al procesar la compra.';
            showMessage(errorMessage, 'bg-red-100 text-red-700');
        }

    } catch (error) {
        console.error('Error de red/servidor:', error);
        showMessage('Error crítico de conexión. Revisa la consola.', 'bg-red-100 text-red-700');
    } finally {
        buyButton.disabled = selectedSeats.length === 0;
        buyButton.textContent = 'Comprar Boletos';
    }
}