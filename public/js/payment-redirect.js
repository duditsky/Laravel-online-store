
(function () {
    document.addEventListener("DOMContentLoaded", function () {
        const liqpayForm = document.getElementById('liqpay-form-auto');
        if (liqpayForm) {
            setTimeout(() => {
                liqpayForm.submit();
            }, 500);
        }
    });
})();