// public/js/categorias.js

function loadElement(category) {
    let categoryId = category.value;

    if (categoryId) {
        fetch(`/categories/${categoryId}/elements`)
            .then(response => {
                if (!response.ok) { // Verifica si la respuesta es exitosa (códigos 2xx)
                    // Usa response.statusText para proporcionar un mensaje de error más descriptivo
                    throw new Error(`HTTP error! Status: ${response.status} (${response.statusText})`);
                }
                return response.json(); // Convierte la respuesta a JSON si fue exitosa
            })
            .then(data => {
                console.log(data);
                // Actualiza el menú desplegable de elementos
                const elementsSelect = document.getElementById('element_id');
                elementsSelect.innerHTML = '<option value="">Selecciona un elemento</option>'; // Limpiar las opciones actuales

                data.forEach(element => {
                    const option = document.createElement('option');
                    option.value = element.id;
                    option.textContent = element.name;
                    elementsSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    } else {
        // Limpiar el menú desplegable si no se selecciona ninguna categoría
        const elementsSelect = document.getElementById('element_id');
        elementsSelect.innerHTML = '<option value="">Selecciona un elemento</option>';
    }
}