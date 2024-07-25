// Función para añadir productos al carrito
function addToCart(event) {
    event.preventDefault();

    // Obtener datos del producto
    const button = event.target.closest('.add-to-cart');
    const productId = button.getAttribute('data-id');
    const productName = button.getAttribute('data-name');
    const productPrice = parseFloat(button.getAttribute('data-price'));
    const productImg = button.getAttribute('data-img');

    // Recuperar carrito del localStorage o crear uno nuevo
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Verificar si el producto ya está en el carrito
    const productIndex = cart.findIndex(product => product.id === productId);

    if (productIndex !== -1) {
        // Si el producto ya está en el carrito, incrementar la cantidad
        cart[productIndex].quantity += 1;
    } else {
        // Si no está en el carrito, añadirlo con cantidad 1
        cart.push({ id: productId, name: productName, price: productPrice, img: productImg, quantity: 1 });
    }

    // Guardar el carrito actualizado en el localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Actualizar la interfaz del carrito
    updateCartUI();
}

// Función para actualizar la interfaz del carrito
function updateCartUI() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCount = cart.reduce((total, product) => total + product.quantity, 0);
    const cartList = document.querySelector('#cart-list');
    const cartSubtotal = cart.reduce((total, product) => total + (product.price * product.quantity), 0);

    // Actualizar contador del carrito
    document.querySelector('#cart-count').innerText = cartCount;

    // Actualizar lista del carrito
    cartList.innerHTML = cart.map(product => `
        <div class="cart-item">
            <img src="${product.img}" alt="${product.name}" style="width: 50px; height: 50px;">
            <span>${product.name}</span>
            <span>${product.quantity} x $${product.price.toFixed(2)}</span>
            <button class="remove-item" data-id="${product.id}">&times;</button>
        </div>
    `).join('');

    // Añadir event listener a los botones de eliminar producto
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', removeFromCart);
    });

    // Actualizar subtotal
    document.querySelector('#cart-subtotal').innerText = `Subtotal: $${cartSubtotal.toFixed(2)}`;
}

// Función para eliminar productos del carrito
function removeFromCart(event) {
    const productId = event.target.getAttribute('data-id');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Filtrar el producto a eliminar
    cart = cart.filter(product => product.id !== productId);

    // Guardar el carrito actualizado en el localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Actualizar la interfaz del carrito
    updateCartUI();
}

// Función para abrir el modal
function openModal() {
    document.getElementById('cart-modal').style.display = 'block';
}

// Función para cerrar el modal
function closeModal() {
    document.getElementById('cart-modal').style.display = 'none';
}

// Añadir event listener a los botones "Añadir al carrito"
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', addToCart);
});

// Event listener para abrir el modal al hacer clic en el botón del carrito
document.getElementById('cart-button').addEventListener('click', openModal);

// Event listener para cerrar el modal
document.querySelector('.close').addEventListener('click', closeModal);

// Inicializar la interfaz del carrito al cargar la página
updateCartUI();

// Redirigir a la página de detalle del carrito
document.getElementById('view-cart-button').addEventListener('click', function() {
    window.location.href = 'cart-detail.html';
});
