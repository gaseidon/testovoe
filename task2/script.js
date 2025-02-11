
const style = document.createElement('style');
style.textContent = '.hidden-field { display: none !important; }';
document.head.appendChild(style);

function updateFieldsVisibility() {
    const typeSelect = document.querySelector('[name="type_val"]');
    if (!typeSelect) {
        console.error('Поле "Тип" не найдено');
        return;
    }

    const selectedValue = typeSelect.value;
    const fields = document.querySelectorAll('input[name], button[name]');
    
    fields.forEach(field => {
        if (field === typeSelect) return; 
        
        const isVisible = field.name.includes(selectedValue);
        field.classList.toggle('hidden-field', !isVisible);
    });
}


const typeSelect = document.querySelector('[name="type_val"]');
if (typeSelect) {
    typeSelect.addEventListener('change', updateFieldsVisibility);
    updateFieldsVisibility();
}