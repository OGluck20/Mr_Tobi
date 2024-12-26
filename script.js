document.addEventListener('DOMContentLoaded', function() {
    // Handle all Join Now buttons
    const joinButtons = document.querySelectorAll('.join-btn');
    joinButtons.forEach(button => {
        button.addEventListener('click', function() {
            // You can replace this with actual group joining logic
            Swal.fire({
                title: 'No Active Link',
                text: 'Please contact the administrator to join this group.',
                icon: 'info',
                confirmButtonColor: '#3498db'
            });
        });
    });
}); 