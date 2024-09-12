// Función para manejar el cambio de categoría
function handleCategoryChange(event) {
    let categoryId = event.target.value; // Obtiene el valor de la categoría seleccionada
    const elementsSelect = document.getElementById('element_id');

    if (categoryId) {
        fetch(`/categories/${categoryId}/elements`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status} (${response.statusText})`);
                }
                return response.json();
            })
            .then(data => {
                console.log(data); // Para depuración
                elementsSelect.innerHTML = '<option value="">Selecciona un elemento</option>';

                data.forEach(element => {
                    const option = document.createElement('option');
                    option.value = element.id;
                    option.textContent = element.name;
                    elementsSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    } else {
        elementsSelect.innerHTML = '<option value="">Selecciona un elemento</option>';
    }
}

// Registra el evento para el cambio en el menú de categorías cuando la página se carga
window.addEventListener('DOMContentLoaded', () => {
    const categorySelect = document.querySelector('select[name="category"]');
    if (categorySelect) {
        categorySelect.addEventListener('change', handleCategoryChange);
    }
});
