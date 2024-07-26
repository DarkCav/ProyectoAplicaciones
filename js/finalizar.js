document.addEventListener('DOMContentLoaded', function() {
    const paymentMethod = document.getElementById('paymentMethod');
    const deliveryOption = document.getElementById('deliveryOption');
    const deliveryAddress = document.getElementById('deliveryAddress');
    const pickupDetails = document.getElementById('pickupDetails');
    const paymentDetails = document.getElementById('paymentDetails');

    paymentMethod.addEventListener('change', function() {
        if (paymentMethod.value === 'credit_card') {
            paymentDetails.style.display = 'block';
        } else {
            paymentDetails.style.display = 'none';
        }
    });

    deliveryOption.addEventListener('change', function() {
        if (deliveryOption.value === 'delivery') {
            deliveryAddress.style.display = 'block';
            pickupDetails.style.display = 'none';
        } else if (deliveryOption.value === 'pickup') {
            deliveryAddress.style.display = 'none';
            pickupDetails.style.display = 'block';
        } else {
            deliveryAddress.style.display = 'none';
            pickupDetails.style.display = 'none';
        }
    });
});
