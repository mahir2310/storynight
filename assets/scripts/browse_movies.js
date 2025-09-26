document.addEventListener('DOMContentLoaded', function() {
    // Search movies
    const searchInput = document.getElementById('movieSearch');
    const movieCards = document.querySelectorAll('.movie-card');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        movieCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });
    
    // Modals
    const bookingModal = document.getElementById('bookingModal');
    const cancelModal = document.getElementById('cancelModal');
    const ticketQuantity = document.getElementById('ticketQuantity');
    const ticketPrice = document.getElementById('ticketPrice');
    const totalPrice = document.getElementById('totalPrice');
    const modalMovieTitle = document.getElementById('modalMovieTitle');
    
    let currentMovieId = null;
    let currentMoviePrice = 0;
    
    // Book button 
    document.querySelectorAll('.btn-book').forEach(btn => {
        btn.addEventListener('click', function() {
            currentMovieId = this.dataset.id;
            currentMoviePrice = parseFloat(this.dataset.price);
            modalMovieTitle.textContent = this.dataset.title;
            ticketPrice.textContent = currentMoviePrice.toFixed(2);
            ticketQuantity.value = 1;
            updateTotalPrice();
            bookingModal.style.display = 'block';
        });
    });
    
    // Cancel booking button 
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', function() {
            cancelModal.style.display = 'block';
        });
    });
    
    function updateTotalPrice() {
        const quantity = parseInt(ticketQuantity.value) || 0;
        totalPrice.textContent = (quantity * currentMoviePrice).toFixed(2);
    }
    
    ticketQuantity.addEventListener('input', updateTotalPrice);
    
    // Close modals
  document.querySelectorAll(".btn-cancel").forEach((btn) => {
    btn.addEventListener("click", function () {
      bookingModal.style.display = "none";
      cancelModal.style.display = "none";
    });
  });

  document.querySelectorAll(".btn-confirm").forEach((btn) => {
    btn.addEventListener("click", async function () {
      const params = new URLSearchParams({
        action: "book",
        movie_id: currentMovieId,
        tickets: ticketQuantity.value,
        total_price: totalPrice.textContent,
      });
      
      await fetch(
        "/storynight/controllers/manageBookingsController.php?" +
          params.toString(),
        { credentials: "include" }
      )
        .then((res) => res.text())
        .then((text) => {
          window.location.href =
            "../../views/customer/customer_layout.php?page=my_bookings";
        })
        .catch((err) => console.error("Fetch error:", err));
      bookingModal.style.display = "none";
      cancelModal.style.display = "none";
    });
  });
});