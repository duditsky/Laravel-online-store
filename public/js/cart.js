
document.addEventListener('DOMContentLoaded', () => {

    document.addEventListener('click', async (e) => {
        const button = e.target.closest('.cart-update-btn');
        if (!button) return;

        const url = button.getAttribute('data-url');
        const productId = button.getAttribute('data-id');

        const countSpan = document.getElementById(`count-${productId}`);
        const itemPriceSpan = document.getElementById(`item-price-${productId}`);
        const totalAmountSpan = document.getElementById('total-amount');
        const totalItemsHeader = document.getElementById('total-items-count') || document.getElementById('basket-count');


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
                if (data.count === 0) {
                    const row = document.getElementById(`row-${productId}`);
                    if (row) row.remove();
                    if (document.querySelectorAll('tbody tr').length === 0) {
                        location.reload();
                        return;
                    }
                } else {
                    if (countSpan) countSpan.innerText = data.count;
                    if (itemPriceSpan) itemPriceSpan.innerText = data.itemPrice;
                }

                if (totalAmountSpan) totalAmountSpan.innerText = data.totalPrice;
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

    document.addEventListener('submit', async function (e) {
        const form = e.target.closest('.delete-all-form');
        if (!form) return;

        e.preventDefault();

        const result = await Swal.fire({
            title: 'Remove item?',
            text: "Are you sure you want to remove all units of this product?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#343a40',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            const url = form.getAttribute('action');
            const row = form.closest('tr');

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
                    row.style.transition = '0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        if (document.querySelectorAll('tbody tr').length === 0) {
                            location.reload();
                        }
                    }, 300);

                    if (document.getElementById('total-amount')) {
                        document.getElementById('total-amount').innerText = data.totalPrice;
                    }
                    const badge = document.getElementById('basket-count') || document.getElementById('total-items-count');
                    if (badge) {
                        badge.innerText = data.fullCount;
                    }
                }
            } catch (error) {
                console.error('Delete Error:', error);
            }
        }
    });
    document.addEventListener('submit', async (e) => {
        const form = e.target.closest('.add-to-cart-form');
        if (!form) return;

        e.preventDefault();

        const url = form.getAttribute('action');
        const formData = new FormData(form);

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                const basketCount = document.getElementById('basket-count');
                if (basketCount) {
                    basketCount.innerText = data.fullCount;
                }

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                

                Toast.fire({
                    icon: 'success',
                    title: data.message,
                    iconColor: '#0d6efd',
                    background: '#fff',
                    color: '#333',
                });
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
        }
    });
});