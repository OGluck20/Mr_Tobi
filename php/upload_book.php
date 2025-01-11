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

$title = $_POST['bookTitle'];
$author = $_POST['bookAuthor'];
$description = $_POST['bookDescription'];
$cover_image = $_FILES['bookCover']['name'];
$file_path = $_FILES['bookFile']['name'];

// Ensure uploads directory exists
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

// Upload files
$cover_image_path = "uploads/" . basename($cover_image);
$file_path_path = "uploads/" . basename($file_path);

if (move_uploaded_file($_FILES['bookCover']['tmp_name'], $cover_image_path) && move_uploaded_file($_FILES['bookFile']['tmp_name'], $file_path_path)) {
    // Insert into database
    $sql = "INSERT INTO books (title, author, description, cover_image, file_path) VALUES ('$title', '$author', '$description', '$cover_image', '$file_path')";

    if ($conn->query($sql) === TRUE) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'New book added successfully'
                    }).then(() => {
                        window.location.href = 'admin.html';
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
                        window.location.href = 'admin.html';
                    });
                });
              </script>";
    }
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to upload files'
                }).then(() => {
                    window.location.href = 'admin.html';
                });
            });
          </script>";
}

$conn->close();
?>