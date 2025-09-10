// JavaScript for Musical Instruments Store
document.addEventListener('DOMContentLoaded', function() {
    // Cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const quantity = document.getElementById('quantity') ? document.getElementById('quantity').value : 1;
            
            addToCart(productId, quantity);
        });
    });
    
    // Wishlist functionality
    const addToWishlistButtons = document.querySelectorAll('.add-to-wishlist');
    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            addToWishlist(productId);
        });
    });
    
    // Quantity controls
    const incrementButtons = document.querySelectorAll('.increment');
    const decrementButtons = document.querySelectorAll('.decrement');
    
    incrementButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            input.value = parseInt(input.value) + 1;
        });
    });
    
    decrementButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });
    
    // Sort products
    const sortSelect = document.getElementById('sortProducts');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            window.location.href = url.toString();
        });
    }
});

// AJAX functions
function addToCart(productId, quantity) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);
    formData.append('action', 'add_to_cart');
    
    fetch('includes/cart-actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Product added to cart!', 'success');
            updateCartCount(data.cart_count);
        } else {
            showAlert('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showAlert('Network error. Please try again.', 'danger');
    });
}

function addToWishlist(productId) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('action', 'add_to_wishlist');
    
    fetch('includes/wishlist-actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Product added to wishlist!', 'success');
        } else {
            showAlert('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showAlert('Network error. Please try again.', 'danger');
    });
}

function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count;
    });
}

function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.classList.remove('show');
            setTimeout(() => alertDiv.remove(), 150);
        }
    }, 3000);
}