document.addEventListener('DOMContentLoaded', function() {
    const booksContainer = document.querySelector('#books-container');
    
    // Show loading state
    booksContainer.innerHTML = '<div class="text-center">Loading books...</div>';

    fetch('php/fetch_books.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.data.length > 0) {
                booksContainer.innerHTML = ''; // Clear loading message
                data.data.forEach(book => {
                    const bookHTML = `
                        <li data-aos="fade-right" data-aos-delay="100">
                            <img src="Book_uploads/${book.cover_image}" 
                                 alt="${book.title}"
                                 onerror="this.src='images/placeholder.jpg'">
                            <h3>${book.title} by ${book.author}</h3>
                            <p>${book.description}</p>
                            <a href="Book_uploads/${book.file_path}" 
                               class="download-btn" 
                               download="${book.file_path}">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </li>
                    `;
                    booksContainer.innerHTML += bookHTML;
                });

                // Initialize AOS after content is loaded
                AOS.refresh();
            } else {
                booksContainer.innerHTML = `
                    <div class="alert alert-info text-center">
                        ${data.message || 'No books available at the moment'}
                    </div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            booksContainer.innerHTML = `
                <div class="alert alert-danger text-center">
                    Failed to load books. Please try again later.
                </div>`;
        });
});