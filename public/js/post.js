/**
 * JOYSTORE Review Management System
 */

let editModal;
let deleteConfirmModal;

document.addEventListener('DOMContentLoaded', function () {
    // 1. Ініціалізація модалок (залишаємо всередині, бо потрібен доступ до DOM)
    const editModalEl = document.getElementById('ajaxEditModal');
    const deleteModalEl = document.getElementById('confirmDeleteModal');

    if (editModalEl) {
        document.body.appendChild(editModalEl);
        editModal = new bootstrap.Modal(editModalEl);
    }

    if (deleteModalEl) {
        document.body.appendChild(deleteModalEl);
        deleteConfirmModal = new bootstrap.Modal(deleteModalEl);
    }

    // Делегування кліку для Edit
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-edit');
        if (btn) {
            e.preventDefault();
            document.getElementById('modal-post-id').value = btn.getAttribute('data-id');
            document.getElementById('modal-post-text').value = btn.getAttribute('data-text');
            editModal.show();
        }
    });
});

// --- ВИНЕСЕНО ЗА МЕЖІ DOMContentLoaded ДЛЯ ГЛОБАЛЬНОГО ДОСТУПУ ---

/**
 * 1. ОНОВЛЕННЯ ВІДГУКУ
 */
window.ajaxUpdatePost = function () {
    const id = document.getElementById('modal-post-id').value;
    const text = document.getElementById('modal-post-text').value;
    const saveBtn = document.getElementById('saveBtn');
    if (!saveBtn) return;
    
    const originalBtnText = saveBtn.innerHTML;

    saveBtn.disabled = true;
    saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Зберігання...';

    fetch(`/posts/${id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ text: text })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const display = document.getElementById(`text-display-${id}`);
            if (display) {
                display.style.opacity = '0';
                setTimeout(() => {
                    display.innerText = text;
                    display.style.opacity = '1';
                }, 200);
            }
            const editBtn = document.querySelector(`.btn-edit[data-id="${id}"]`);
            if (editBtn) editBtn.setAttribute('data-text', text);
            editModal.hide();
        }
    })
    .catch(err => alert('Помилка при збереженні'))
    .finally(() => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalBtnText;
    });
};

/**
 * 2. ВІДКРИТТЯ МОДАЛКИ ВИДАЛЕННЯ
 */
window.ajaxDeletePost = function (id) {
    const input = document.getElementById('delete-post-id');
    if (input) input.value = id;
    
    if (deleteConfirmModal) {
        deleteConfirmModal.show();
    } else {
        // Якщо модалка не встигла ініціалізуватися, пробуємо ще раз
        const el = document.getElementById('confirmDeleteModal');
        deleteConfirmModal = new bootstrap.Modal(el);
        deleteConfirmModal.show();
    }
};

/**
 * 3. ПІДТВЕРДЖЕНЕ ВИДАЛЕННЯ
 */
window.confirmAjaxDelete = function () {
    const id = document.getElementById('delete-post-id').value;
    const confirmBtn = document.getElementById('confirmDeleteBtn') || document.querySelector('#confirmDeleteModal .btn-danger');
    const originalBtnText = confirmBtn.innerHTML;

    confirmBtn.disabled = true;
    confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

    fetch(`/posts/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById(`post-row-${id}`);
            if (row) {
                row.style.transition = 'all 0.5s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(100px)';
                setTimeout(() => {
                    row.remove();
                    const countEl = document.getElementById('total-count');
                    if (countEl) countEl.innerText = Math.max(0, parseInt(countEl.innerText) - 1);
                }, 500);
            }
            deleteConfirmModal.hide();
        }
    })
    .catch(err => alert('Не вдалося видалити'))
    .finally(() => {
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = originalBtnText;
    });
};