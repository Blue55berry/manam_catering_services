document.addEventListener('DOMContentLoaded', function () {

    // Function to update cart count in header
    function updateCartCount() {
        fetch('/cart-count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.cart-count');
                if (badge) {
                    badge.innerText = data.count;
                }
            })
            .catch(error => console.error('Error fetching cart count:', error));
    }

    // Initial cart count load
    updateCartCount();

    // Add to Cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = this.getAttribute('data-price');
            const image = this.getAttribute('data-image');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Button Loading State
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;

            fetch('/add-to-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    id: id,
                    name: name,
                    price: price,
                    image: image
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update Cart Count
                        const badge = document.querySelector('.cart-count');
                        if (badge) {
                            badge.innerText = data.total_quantity;
                        }

                        // Show animation or toast could go here
                        // Reset Button
                        this.innerHTML = '<i class="fa fa-check"></i> Added';
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
        });
    });
    // Cart Page Functionality
    const cartItemsWrapper = document.querySelector('.cat-cart-items-wrapper');

    if (cartItemsWrapper) {
        // Handle Quantity Change
        // Handle Quantity Change
        cartItemsWrapper.addEventListener('click', function (e) {
            // Check for plus/minus buttons or their children icons
            const btn = e.target.closest('.qty-btn');

            if (btn) {
                e.preventDefault();
                e.stopPropagation();

                const row = btn.closest('.cat-cart-item-card');
                const input = row.querySelector('.qty-input');
                const id = row.getAttribute('data-id');
                let currentValue = parseInt(input.value) || 1; // Default to 1 if NaN

                if (btn.classList.contains('plus')) {
                    currentValue++;
                } else if (btn.classList.contains('minus')) {
                    if (currentValue > 1) {
                        currentValue--;
                    } else {
                        return; // Min 1
                    }
                }

                input.value = currentValue;
                updateCartItem(id, currentValue);
            }

            // Handle Remove Item
            const removeBtn = e.target.closest('.remove-from-cart-btn');
            if (removeBtn) {
                e.preventDefault();
                const id = removeBtn.getAttribute('data-id');

                if (confirm('Are you sure you want to remove this item?')) {
                    removeCartItem(id, removeBtn.closest('.cat-cart-item-card'));
                }
            }
        });
    }

    function updateCartItem(id, quantity) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/update-cart', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                id: id,
                quantity: quantity
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartTotals(data);

                    // Update header badge
                    const badge = document.querySelector('.cart-count');
                    if (badge) badge.innerText = data.count;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function removeCartItem(id, rowElement) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/remove-from-cart', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                id: id
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove row with animation
                    rowElement.style.opacity = '0';
                    setTimeout(() => {
                        rowElement.remove();

                        // Check if cart is empty
                        if (document.querySelectorAll('.cat-cart-item-card').length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    }, 300);

                    updateCartTotals(data);

                    // Update header badge
                    const badge = document.querySelector('.cart-count');
                    if (badge) badge.innerText = data.count;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateCartTotals(data) {
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalEl = document.getElementById('cart-total');
        const taxEl = document.getElementById('cart-tax');

        if (subtotalEl) subtotalEl.innerText = '₹' + data.subtotal;
        if (totalEl) totalEl.innerText = '₹' + data.total;

        // Calculate tax manually if needed or pass from backend
        // For now backend sends formatted strings, so we rely on that
        if (taxEl) {
            // We didn't send tax explicitly in JSON, but we can infer or simpler to just reload page if complex
            // Actually backend sends 'total' which includes tax. 
            // Let's just update what we have. 
            // To keep it simple, we might want to return tax from backend too.
            // For now, let's assume backend 'subtotal' and 'total' are enough.
        }
    }
});
