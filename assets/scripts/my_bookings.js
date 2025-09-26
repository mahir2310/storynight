

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
    
    // open Cancel booking
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', function() {
            currentBookingId = this.dataset.id;
            currentMovieId = this.dataset.mid;
            cancelModal.style.display = 'block';
        });
    });
    
    // Close modal
    document.querySelectorAll('.btn-cancel.btn-modal').forEach(btn => {
        btn.addEventListener('click', function() {
            cancelModal.style.display = 'none';
        });
    });
    
    // Confirm cancel booking
  document.querySelector(".btn-confirm").addEventListener("click", async function () {
    if (currentBookingId) {
      cancelModal.style.display = "none";

      const params = new URLSearchParams({
        action: "cancel",
        movie_id: currentMovieId,
      });

      try {
        const response = await fetch(
          "/storynight/controllers/manageBookingsController.php?" + params.toString()
        );
        const result = await response.json();

        if (result.success) {
          alert(result.message || "Booking cancelled successfully!");
          location.reload();
        } else {
          alert(result.message || "Failed to cancel booking.");
        }
      } catch (err) {
        console.error("Fetch error:", err);
        alert("An error occurred while cancelling booking.");
      }
    }
  });
    
});