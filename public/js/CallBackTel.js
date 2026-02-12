function initPhoneMask() {
    const phoneElement = document.getElementById('phoneInput');
    if (!phoneElement || typeof IMask === 'undefined') return;

    const maskOptions = {
        // Ми робимо нуль частиною маски, яка не змінюється
        mask: '+38 (\\000) 000-00-00',
        lazy: false,
        placeholderChar: '_',
        definitions: {
            // Тепер '0' у масці перед іншими цифрами буде сприйматися як текст
            '\\0': {
                mask: '0',
                placeholder: '0',
                fixed: true // Це не дасть його змінити
            }
        }
    };

    const mask = IMask(phoneElement, maskOptions);

    function setCursor() {
        // Позиція 7 — це відразу після (0
        // Якщо введено менше 2 цифр (тільки наш префікс), повертаємо курсор
        if (mask.unmaskedValue.length <= 1) {
            setTimeout(() => {
                phoneElement.setSelectionRange(7, 7);
            }, 10);
        }
    }

    phoneElement.addEventListener('focus', setCursor);
    phoneElement.addEventListener('click', setCursor);
}

// Запуск
document.addEventListener('DOMContentLoaded', initPhoneMask);
const modal = document.getElementById('callbackModal');
if (modal) {
    modal.addEventListener('shown.bs.modal', initPhoneMask);
}