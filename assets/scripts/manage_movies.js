document.addEventListener('DOMContentLoaded', function() {
    // Search Movies
    const searchInput = document.getElementById('movieSearch');
    const tableRows = document.querySelectorAll('.movies-table tbody tr');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Modal for delete movie
    const modal = document.getElementById('deleteModal');
    const movieTitleSpan = document.getElementById('movieTitle');
    const cancelBtn = document.querySelector('.btn-cancel');
    let movieIdToDelete = null;
    
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            movieIdToDelete = this.getAttribute('data-movie-id');
            const title = this.getAttribute('data-movie-title');
            movieTitleSpan.textContent = title;
            modal.style.display = 'block';
        });
    });
    
    cancelBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        movieIdToDelete = null;
    });
    
    // Handle delete 
    document
    .querySelector(".btn-confirm-delete")
    .addEventListener("click", async function () {
      if (movieIdToDelete) {
        const params = new URLSearchParams({
          action: "delete",
          movie_id: movieIdToDelete,
        });

        await fetch(
          "/storynight/controllers/manageMoviesController.php?" +
            params.toString()
        )
          .then((res) => {
            res.text();
            location.reload();
          })
          .catch((err) => console.error("Fetch error:", err));
      }
    });

    // Modal for discount
    const discountModal = document.getElementById("discountModal");
    const discountMovieTitle = document.getElementById("discountMovieTitle");
    const discountInput = document.getElementById("discountInput");
    let movieIdToDiscount = null;
  
    document.querySelectorAll(".btn-discount").forEach((button) => {
      button.addEventListener("click", function () {
        movieIdToDiscount = this.closest("tr")
          .querySelector(".btn-delete")
          .getAttribute("data-movie-id");
        const title = this.closest("tr")
          .querySelector(".btn-delete")
          .getAttribute("data-movie-title");
        discountMovieTitle.textContent = title;
        discountInput.value = "";
        discountModal.style.display = "block";
      });
    });
  
    document
      .querySelector(".btn-cancel-discount")
      .addEventListener("click", function () {
        discountModal.style.display = "none";
        movieIdToDiscount = null;
      });
  
    document
      .querySelector(".btn-confirm-discount")
      .addEventListener("click", async function () {
        const discountValue = discountInput.value.trim();
        if (movieIdToDiscount && discountValue !== "") {
          const params = new URLSearchParams({
            action: "add_discount",
            movie_id: movieIdToDiscount,
            discount: discountValue,
          });
  
          await fetch(
            "/storynight/controllers/manageMoviesController.php?" +
              params.toString()
          )
            .then((res) => {
              res.text();
              location.reload();
            })
            .catch((err) => console.error("Fetch error:", err));
  
          discountModal.style.display = "none";
          movieIdToDiscount = null;
        }
      });
});