<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Define number of items per page
$items_per_page = 6;

// Get current page from query string or set to 1 if not present
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting point for the current page
$start_from = ($current_page - 1) * $items_per_page;

// Get the total number of items
$total_items_query = "SELECT COUNT(*) AS total FROM food";
$total_items_result = $conn->query($total_items_query);
$total_items_row = $total_items_result->fetch_assoc();
$total_items = $total_items_row['total'];

// Calculate total pages
$total_pages = ceil($total_items / $items_per_page);

// Fetch items for the current page
$get_recent_query = "SELECT * FROM food ORDER BY food.id DESC LIMIT $start_from, $items_per_page";
$result = $conn->query($get_recent_query);

$items = ""; // Initialize the $items variable 

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items .= "<div class='col-md-4 mb-4'>
                        <div class='card'>
                            <img src='.././image/FoodPics/".$row['id'].".jpg' class='card-img-top zoomable' alt='".$row['food_name']."'>
                            <div class='card-body'>
                                <h5 class='card-title'>".$row['food_name']."</h5>
                                <p class='card-text'>".substr($row['food_description'], 0, 33)."...</p>
                                <p class='card-price'>#".$row['food_price']."</p>
                            </div>
                        </div>
                    </div>";
    }
} else {
    $items = "<div class='col-12'><p>No recent items found.</p></div>";
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="userstyle.css">
    <link href="../assets/img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <?php include "Nav.php";?>

    <div class="container mt-5">
        <div class="text-center mb-4">
            <button class="btn btn-dark mt-5 w-50" href="reservation.php">
                <a href="reservation.php" class="text-decoration-none text-light fw-bolder" style="letter-spacing: 3px;">Table Book</a>
            </button>
        </div>

        <div class="text-center mb-4">
            <h2><span class="fresh">Discover Fresh Menu</span></h2>
        </div>

        <div class="row">
            <?php echo $items; ?>
        </div>

        <!-- Pagination Controls -->
        <div class="text-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Image Zoom Modal -->
    <div id="imageZoomModal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="zoomedImage" src="" class="img-fluid" alt="Zoomed Image">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        document.querySelectorAll('.zoomable').forEach(item => {
            item.addEventListener('click', event => {
                const src = event.target.src;
                document.getElementById('zoomedImage').src = src;
                const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
                modal.show();
            });
        });
    </script>
</body>
</html>


<style>
    .card {
  border: none;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.card-img-top {
  height: 200px;
  object-fit: cover;
  cursor: pointer; /* Indicates that the image is clickable */
}
.card-title {
  font-size: 1.25rem;
  font-weight: bold;
}
.card-text {
  font-size: 0.875rem;
}
.card-price {
  font-size: 1rem;
  font-weight: bold;
  color: #dc3545; /* Bootstrap's danger color */
}
.btn-primary {
  background-color: #27ae60;
  border-color: #27ae60;
}
.btn-primary:hover {
  background-color: #dc3545;
  border-color: #dc3545;
}
.pagination .page-item.active .page-link {
  background-color: #27ae60;
  border-color: #27ae60;
}
.pagination .page-link {
  color: black;
}
.pagination .page-link:hover {
  background-color: #27ae70;
  border-color: #27ae70;
}
/* Modal Styles */
.modal-content {
  border: none;
  border-radius: 10px;
}
.modal-body {
  padding: 0;
}

</style>