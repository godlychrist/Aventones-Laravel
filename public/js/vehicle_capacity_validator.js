/**
 * Vehicle Capacity Validator
 * 
 * Este script maneja:
 * 1. Validación de capacidad máxima de 4 asientos para vehículos
 * 2. Validación de asientos disponibles en rides (1-4)
 * 3. Actualización dinámica de asientos según vehículo seleccionado
 */

// ============================================
// VALIDACIÓN DE FORMULARIO DE VEHÍCULOS
// ============================================

/**
 * Inicializa la validación para formularios de vehículos
 */
function initVehicleCapacityValidation() {
    const capacityInput = document.querySelector('input[name="capacity"]');

    if (!capacityInput) return;

    // Establecer máximo de 4
    capacityInput.setAttribute('max', '4');

    // Validación en tiempo real
    capacityInput.addEventListener('input', function () {
        const value = parseInt(this.value);

        if (value > 4) {
            this.value = 4;
            showValidationMessage(this, 'La capacidad máxima permitida es de 4 pasajeros');
        } else if (value < 1) {
            this.value = 1;
            showValidationMessage(this, 'La capacidad mínima es de 1 pasajero');
        } else {
            clearValidationMessage(this);
        }
    });

    // Validación antes de enviar el formulario
    const form = capacityInput.closest('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            const value = parseInt(capacityInput.value);

            if (value < 1 || value > 4) {
                e.preventDefault();
                alert('La capacidad del vehículo debe estar entre 1 y 4 pasajeros');
                capacityInput.focus();
                return false;
            }
        });
    }
}

// ============================================
// VALIDACIÓN DE FORMULARIO DE RIDES
// ============================================

/**
 * Inicializa la validación para formularios de rides
 */
function initRideSpaceValidation() {
    const spaceInput = document.querySelector('input[name="space"]');
    const vehicleSelect = document.querySelector('select[name="vehicle_id"]');

    if (!spaceInput) return;

    // Establecer máximo de 4 por defecto
    spaceInput.setAttribute('max', '4');

    // Si hay un selector de vehículo, actualizar el máximo según el vehículo seleccionado
    if (vehicleSelect) {
        // Actualizar inmediatamente al cargar la página (importante para formularios de edición)
        // No mostrar mensaje en la carga inicial
        updateMaxSpaceFromVehicle(vehicleSelect, spaceInput, false);

        // Actualizar cuando cambie el vehículo seleccionado
        // Mostrar mensaje cuando el usuario cambia el vehículo
        vehicleSelect.addEventListener('change', function () {
            updateMaxSpaceFromVehicle(this, spaceInput, true);
        });
    }

    // Validación en tiempo real
    spaceInput.addEventListener('input', function () {
        const value = parseInt(this.value);
        const maxValue = parseInt(this.getAttribute('max')) || 4;

        if (value > maxValue) {
            this.value = maxValue;
            showValidationMessage(this, `El máximo de asientos disponibles es ${maxValue} según la capacidad del vehículo`);
        } else if (value < 1) {
            this.value = 1;
            showValidationMessage(this, 'Debe haber al menos 1 asiento disponible');
        } else {
            clearValidationMessage(this);
        }
    });

    // Validación antes de enviar el formulario
    const form = spaceInput.closest('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            const value = parseInt(spaceInput.value);
            const maxValue = parseInt(spaceInput.getAttribute('max')) || 4;

            if (value < 1 || value > maxValue) {
                e.preventDefault();
                alert(`Los asientos disponibles deben estar entre 1 y ${maxValue}`);
                spaceInput.focus();
                return false;
            }
        });
    }
}

/**
 * Actualiza el máximo de asientos según el vehículo seleccionado
 * @param {HTMLSelectElement} vehicleSelect - El selector de vehículos
 * @param {HTMLInputElement} spaceInput - El input de asientos
 * @param {boolean} showMessage - Si debe mostrar mensaje cuando se ajusta
 */
function updateMaxSpaceFromVehicle(vehicleSelect, spaceInput, showMessage = true) {
    const selectedOption = vehicleSelect.options[vehicleSelect.selectedIndex];

    if (!selectedOption || !selectedOption.value) {
        spaceInput.setAttribute('max', '4');
        spaceInput.setAttribute('placeholder', '1-4');
        return;
    }

    // Obtener la capacidad del vehículo mediante data attribute
    const vehicleCapacity = selectedOption.getAttribute('data-capacity');

    if (vehicleCapacity) {
        const capacity = parseInt(vehicleCapacity);
        spaceInput.setAttribute('max', capacity);
        spaceInput.setAttribute('placeholder', `1-${capacity}`);

        // Si el valor actual excede la nueva capacidad, ajustarlo
        const currentValue = parseInt(spaceInput.value);
        if (currentValue > capacity) {
            spaceInput.value = capacity;
            if (showMessage) {
                showValidationMessage(spaceInput, `Ajustado a ${capacity} asientos (capacidad del vehículo)`);
            }
        }
    } else {
        // Si no hay data-capacity, hacer una petición AJAX para obtenerla
        fetchVehicleCapacity(selectedOption.value, spaceInput, showMessage);
    }
}

/**
 * Obtiene la capacidad del vehículo mediante AJAX
 * @param {string} vehicleId - ID del vehículo
 * @param {HTMLInputElement} spaceInput - El input de asientos
 * @param {boolean} showMessage - Si debe mostrar mensaje cuando se ajusta
 */
function fetchVehicleCapacity(vehicleId, spaceInput, showMessage = true) {
    // Crear URL para obtener datos del vehículo
    const url = `/api/vehicles/${vehicleId}/capacity`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('No se pudo obtener la capacidad del vehículo');
            }
            return response.json();
        })
        .then(data => {
            const capacity = parseInt(data.capacity) || 4;
            spaceInput.setAttribute('max', capacity);
            spaceInput.setAttribute('placeholder', `1-${capacity}`);

            // Si el valor actual excede la nueva capacidad, ajustarlo
            const currentValue = parseInt(spaceInput.value);
            if (currentValue > capacity) {
                spaceInput.value = capacity;
                if (showMessage) {
                    showValidationMessage(spaceInput, `Ajustado a ${capacity} asientos (capacidad del vehículo)`);
                }
            }
        })
        .catch(error => {
            console.error('Error al obtener capacidad del vehículo:', error);
            // Usar valor por defecto de 4
            spaceInput.setAttribute('max', '4');
        });
}

// ============================================
// FUNCIONES AUXILIARES
// ============================================

/**
 * Muestra un mensaje de validación debajo del input
 */
function showValidationMessage(input, message) {
    clearValidationMessage(input);

    const messageDiv = document.createElement('div');
    messageDiv.className = 'validation-message text-warning small mt-1';
    messageDiv.textContent = message;
    messageDiv.setAttribute('data-validation-message', 'true');

    input.parentNode.appendChild(messageDiv);

    // Auto-ocultar después de 3 segundos
    setTimeout(() => {
        clearValidationMessage(input);
    }, 3000);
}

/**
 * Limpia el mensaje de validación
 */
function clearValidationMessage(input) {
    const existingMessage = input.parentNode.querySelector('[data-validation-message]');
    if (existingMessage) {
        existingMessage.remove();
    }
}

// ============================================
// INICIALIZACIÓN
// ============================================

/**
 * Inicializa todas las validaciones cuando el DOM esté listo
 */
document.addEventListener('DOMContentLoaded', function () {
    // Detectar qué tipo de formulario es y aplicar validaciones correspondientes
    const isVehicleForm = document.querySelector('input[name="plateNum"]') !== null;
    const isRideForm = document.querySelector('input[name="space"]') !== null;

    if (isVehicleForm) {
        initVehicleCapacityValidation();
    }

    if (isRideForm) {
        initRideSpaceValidation();
    }
});
