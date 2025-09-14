

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('bookingSearch');
    const movieCards = document.querySelectorAll('.movie-card');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        movieCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });
    
    const cancelModal = document.getElementById('cancelModal');
    let currentBookingId = null;
    
    // Cancel booking
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', function() {
            currentBookingId = this.dataset.id;
            cancelModal.style.display = 'block';
        });
    });
    
    // Close modal
    document.querySelectorAll('.btn-cancel.btn-modal').forEach(btn => {
        btn.addEventListener('click', function() {
            cancelModal.style.display = 'none';
        });
    });
    
    // Confirm 
    document.querySelector('.btn-confirm').addEventListener('click', function() {
        if (currentBookingId) {
            alert(`Booking #${currentBookingId} cancelled successfully!`);
            cancelModal.style.display = 'none';
            // In real app: AJAX request to cancel booking
        }
    });
    
});