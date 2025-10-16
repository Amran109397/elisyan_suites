// invoice.js - Specialized JavaScript for invoice and booking confirmation pages

document.addEventListener('DOMContentLoaded', function() {
    
    // ====== BOOKING CONFIRMATION PAGE FUNCTIONALITY ======
    
    // Countdown timer for redirect to invoice page
    const countdownElement = document.getElementById('countdown');
    if (countdownElement) {
        console.log("Countdown element found, starting timer");
        let seconds = 5;
        
        const countdownInterval = setInterval(function() {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdownInterval);
                console.log("Redirecting to invoice page");
                window.location.href = "invoice.html";
            }
        }, 1000);
    }
    
    // ====== INVOICE PAGE FUNCTIONALITY ======
    
    // Print invoice functionality
    const printInvoiceBtn = document.getElementById('printInvoice');
    if (printInvoiceBtn) {
        console.log("Print button found, adding event listener");
        printInvoiceBtn.addEventListener('click', function() {
            console.log("Print button clicked");
            window.print();
        });
    }
    
    // Download PDF functionality (simulated)
    const downloadInvoiceBtn = document.getElementById('downloadInvoice');
    if (downloadInvoiceBtn) {
        console.log("Download button found, adding event listener");
        downloadInvoiceBtn.addEventListener('click', function() {
            console.log("Download button clicked");
            
            // Create a simple notification instead of alert
            const notification = document.createElement('div');
            notification.className = 'alert alert-info position-fixed top-0 start-50 translate-middle-x mt-3';
            notification.style.zIndex = '9999';
            notification.innerHTML = `
                <i class="fas fa-info-circle me-2"></i>
                PDF download would start here. This is a simulation.
                <button type="button" class="btn-close" aria-label="Close"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
            
            // Also allow manual close
            notification.querySelector('.btn-close').addEventListener('click', () => {
                notification.remove();
            });
        });
    }
});