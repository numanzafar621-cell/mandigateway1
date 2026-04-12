// =============================================
// MandiGateway - Main JavaScript File
// =============================================

document.addEventListener('DOMContentLoaded', function() {

    // ============== TinyMCE Auto Save Alert ==============
    console.log('%c MandiGateway JS Loaded Successfully ✅', 'color: #0d6efd; font-weight: bold;');

    // ============== WhatsApp Button Animation ==============
    const whatsappButtons = document.querySelectorAll('.whatsapp-float');
    whatsappButtons.forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.transform = 'scale(1.15)';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'scale(1)';
        });
    });

    // ============== Add to Cart Animation ==============
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check"></i> Added!';
            this.style.backgroundColor = '#28a745';
            
            setTimeout(() => {
                this.innerHTML = originalText;
                this.style.backgroundColor = '';
            }, 2000);
        });
    });

    // ============== Confirm Delete Function ==============
    window.confirmDelete = function(message = 'Are you sure you want to delete this?') {
        return confirm(message);
    };

    // ============== Search Input Auto Focus ==============
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.focus();
    }

    // ============== Price Format Helper ==============
    window.formatPrice = function(price) {
        return new Intl.NumberFormat('ur-PK', {
            style: 'currency',
            currency: 'PKR',
            minimumFractionDigits: 0
        }).format(price);
    };

    // ============== Mobile Menu Toggle ==============
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            console.log('Mobile menu toggled');
        });
    }

    // ============== Image Preview Before Upload ==============
    const imageInputs = document.querySelectorAll('input[type="file"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // ============== Auto Hide Alerts ==============
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

});

// ============== Global Functions ==============

// Copy Store Link to Clipboard
function copyStoreLink(link) {
    navigator.clipboard.writeText(link).then(() => {
        const toast = document.createElement('div');
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.left = '50%';
        toast.style.transform = 'translateX(-50%)';
        toast.style.background = '#28a745';
        toast.style.color = 'white';
        toast.style.padding = '12px 25px';
        toast.style.borderRadius = '50px';
        toast.style.zIndex = '9999';
        toast.textContent = '✅ Store link copied!';
        document.body.appendChild(toast);
        
        setTimeout(() => toast.remove(), 2500);
    });
}

// ============== Ready for Production ==============
console.log('%c MandiGateway - All JS functions are ready!', 'color: green; font-size: 14px;');