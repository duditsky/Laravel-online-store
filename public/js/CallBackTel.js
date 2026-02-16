let phoneMask;

function initPhoneMask() {
    const phoneElement = document.getElementById('phoneInput');
    if (!phoneElement || typeof IMask === 'undefined') return;

    if (phoneMask) phoneMask.destroy();

    const maskOptions = {
        mask: '+38 (\\000) 000-00-00',
        lazy: false,
        placeholderChar: '_',
        overwrite: true,
        definitions: {
            '0': {
                mask: '0',
                fixed: true
            }
        }
    };

    phoneMask = IMask(phoneElement, maskOptions);

    const setCursor = () => {
        if (phoneMask.unmaskedValue.length <= 1) {
            setTimeout(() => {
                phoneElement.setSelectionRange(6, 6);
            }, 10);
        }
    };

    phoneElement.addEventListener('focus', setCursor);
    phoneElement.addEventListener('click', setCursor);
}

document.addEventListener('DOMContentLoaded', () => {
    const modalElement = document.getElementById('callbackModal');
    if (modalElement) {
        modalElement.addEventListener('shown.bs.modal', initPhoneMask);
        modalElement.addEventListener('hidden.bs.modal', () => {
            const form = modalElement.querySelector('form');
            if (form) form.reset();
            if (phoneMask) {
                phoneMask.destroy();
                phoneMask = null;
            }
        });
    }
});