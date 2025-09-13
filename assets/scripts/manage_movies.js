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
    document.querySelector('.btn-confirm-delete').addEventListener('click', function() {
        if (movieIdToDelete) {
            //window.location.href = `manage_movies.php?action=delete&id=${movieIdToDelete}`;
        }
    });
});