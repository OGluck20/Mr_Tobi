document.addEventListener('DOMContentLoaded', function() {
    fetch('php/fetch_posts.php')
        .then(response => response.json())
        .then(data => {
            const blogContainer = document.getElementById('blogPosts');
            
            if (Array.isArray(data)) {
                data.forEach(post => {
                    const postHTML = `
                        <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                            <div class="blog-card">
                                ${post.image_path ? `<img src="uploads/${post.image_path}" alt="${post.title}" class="img-fluid">` : ''}
                                <div class="blog-content">
                                    <h3>${post.title}</h3>
                                    <p class="timestamp">Posted on: <span>${post.created_at}</span></p>
                                    <p>${post.content}</p>
                                    <a href="#" class="read-more">Read More</a>
                                </div>
                            </div>
                        </div>
                    `;
                    blogContainer.innerHTML += postHTML;
                });
            } else {
                blogContainer.innerHTML = '<div class="col-12"><p class="text-center">No blog posts available</p></div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('blogPosts').innerHTML = '<div class="col-12"><p class="text-center">Error loading blog posts</p></div>';
        });
});