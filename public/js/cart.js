/**
 * JoyStore Cart Logic with SweetAlert2 integration
 */
document.addEventListener('DOMContentLoaded', () => {

    // 1. ОБРОБКА КНОПОК ПЛЮС/МІНУС (AJAX)
    document.addEventListener('click', async (e) => {
        const button = e.target.closest('.cart-update-btn');
        if (!button) return;

        const url = button.getAttribute('data-url');
        const productId = button.getAttribute('data-id');
        
        const countSpan = document.getElementById(`count-${productId}`);
        const itemPriceSpan = document.getElementById(`item-price-${productId}`);
        const totalAmountSpan = document.getElementById('total-amount');
        const totalItemsHeader = document.getElementById('total-items-count') || document.getElementById('basket-count');

        // Блокуємо кнопку та візуально змінюємо прозорість лічильника
        button.disabled = true;
        if (countSpan) countSpan.style.opacity = '0.5';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) throw new Error(`Server status: ${response.status}`);

            const data = await response.json();

            if (data.success) {
                // Видалення рядка, якщо кількість стала 0
                if (data.count === 0) {
                    const row = document.getElementById(`row-${productId}`);
                    if (row) row.remove();
                    if (document.querySelectorAll('tbody tr').length === 0) {
                        location.reload();
                        return;
                    }
                } else {
                    // Оновлення кількості та проміжної ціни товару
                    if (countSpan) countSpan.innerText = data.count;
                    if (itemPriceSpan) itemPriceSpan.innerText = data.itemPrice;
                }

                // Оновлення загальної суми кошика
                if (totalAmountSpan) totalAmountSpan.innerText = data.totalPrice;

                // Оновлення бейджа в хедері
                if (totalItemsHeader) {
                    totalItemsHeader.innerText = data.fullCount;
                    if (data.fullCount > 0) {
                        totalItemsHeader.classList.replace('bg-secondary', 'bg-danger');
                    } else {
                        totalItemsHeader.classList.replace('bg-danger', 'bg-secondary');
                    }
                }
            }
        } catch (error) {
            console.error('Cart Update Error:', error);
            // Англомовна помилка через SweetAlert2
            Swal.fire({
                title: 'Oops!',
                text: 'Could not update the cart. Please try again later.',
                icon: 'error',
                confirmButtonColor: '#ffc107',
                borderRadius: '15px'
            });
        } finally {
            button.disabled = false;
            if (countSpan) countSpan.style.opacity = '1';
        }
    });

    // 2. СТИЛЬНЕ ПІДТВЕРДЖЕННЯ ВИДАЛЕННЯ (SweetAlert2)
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('.delete-all-form');
        if (!form) return;

        e.preventDefault();
        
        // Англомовний модал підтвердження
        Swal.fire({
            title: 'Remove item?',
            text: "Are you sure you want to remove all units of this product?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107', // JoyStore Yellow
            cancelButtonColor: '#343a40',  // Dark Gray
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel',
            borderRadius: '15px',
            background: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});