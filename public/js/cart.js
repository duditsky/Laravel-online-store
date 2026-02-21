document.addEventListener('DOMContentLoaded', () => {

    // 1. ПЛЮС ТА МІНУС (Оновлення кількості)
    document.addEventListener('click', async (e) => {
        const button = e.target.closest('.cart-update-btn');
        if (!button) return;

        e.preventDefault();
        const url = button.getAttribute('data-url');
        const productId = button.getAttribute('data-id');

        // Знаходимо всі елементи для оновлення
        const countSpan = document.getElementById(`count-${productId}`);
        const itemPriceSpan = document.getElementById(`item-price-${productId}`);
        const totalAmountSpan = document.getElementById('total-amount');
        const basketBadge = document.getElementById('basket-count');
        const totalItemsHeader = document.getElementById('total-items-count');

        button.disabled = true; // Блокуємо кнопку, щоб не спамили

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Якщо товар видалено (кількість 0)
                if (data.count === 0) {
                    const row = document.getElementById(`row-${productId}`);
                    if (row) row.remove();
                    // Якщо кошик став порожнім - перезавантажуємо сторінку
                    if (document.querySelectorAll('tbody tr').length === 0) {
                        location.reload();
                        return;
                    }
                }

                // Оновлюємо цифри в рядку (Кількість та Сума за позицію)
                if (countSpan) countSpan.innerText = data.count;
                if (itemPriceSpan) itemPriceSpan.innerText = data.itemPrice;

                // Оновлюємо загальну суму кошика
                if (totalAmountSpan) totalAmountSpan.innerText = data.totalPrice;

                // Оновлюємо лічильники (Бадж у шапці та текст у кошику)
                if (basketBadge) {
                    basketBadge.innerText = data.fullCount;
                    if (data.fullCount > 0) {
                        basketBadge.classList.replace('bg-secondary', 'bg-danger');
                    } else {
                        basketBadge.classList.replace('bg-danger', 'bg-secondary');
                    }
                }
                if (totalItemsHeader) {
                    totalItemsHeader.innerText = data.fullCount;
                }
            }
        } catch (error) {
            console.error('Помилка оновлення:', error);
        } finally {
            button.disabled = false;
        }
    });

    // 2. ВИДАЛЕННЯ ТОВАРУ ПОВНІСТЮ (Смітник)
    document.addEventListener('submit', async (e) => {
        const form = e.target.closest('.delete-all-form');
        if (!form) return;

        e.preventDefault();
        const result = await Swal.fire({
            title: 'Delete item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            confirmButtonText: 'Yes, delete'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(form.getAttribute('action'), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    form.closest('tr').remove();
                    if (document.querySelectorAll('tbody tr').length === 0) {
                        location.reload();
                    } else {
                        if (document.getElementById('total-amount')) 
                            document.getElementById('total-amount').innerText = data.totalPrice;
                        if (document.getElementById('basket-count')) 
                            document.getElementById('basket-count').innerText = data.fullCount;
                        if (document.getElementById('total-items-count')) 
                            document.getElementById('total-items-count').innerText = data.fullCount;
                    }
                }
            } catch (error) {
                console.error('Error deleting item:', error);
            }
        }
    });

    // 3. ДОДАВАННЯ В КОШИК (З каталогу)
    document.addEventListener('submit', async (e) => {
        const form = e.target.closest('.add-to-cart-form');
        if (!form) return;

        e.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch(form.getAttribute('action'), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            const data = await response.json();
            if (data.success) {
                const badge = document.getElementById('basket-count');
                if (badge) badge.innerText = data.fullCount;

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        } catch (error) {
            console.error('Error adding item:', error);
        }
    });
});