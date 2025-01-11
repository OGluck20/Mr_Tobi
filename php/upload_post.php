<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "educonsult";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = $_POST['postTitle'];
$content = $_POST['postContent'];
$image_path = $_FILES['postImage']['name'];

// Ensure uploads directory exists
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

// Upload image if provided
if ($image_path) {
    $image_path_full = "../uploads/" . basename($image_path);
    if (!move_uploaded_file($_FILES['postImage']['tmp_name'], $image_path_full)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to upload image'
                    }).then(() => {
                        window.location.href = '../admin.html';
                    });
                });
              </script>";
        exit;
    }
}

// Insert into database
$sql = "INSERT INTO blog_posts (title, content, image_path) VALUES ('$title', '$content', '$image_path')";

if ($conn->query($sql) === TRUE) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'New post added successfully'
                }).then(() => {
                    window.location.href = '../admin.html';
                });
            });
          </script>";
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: " . $sql . "<br>" . $conn->error . "'
                }).then(() => {
                    window.location.href = '../admin.html';
                });
            });
          </script>";
}

$conn->close();
?>