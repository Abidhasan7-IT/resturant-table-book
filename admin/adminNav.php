<!-- nav bar starts -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap');
* {
	font-family: 'Montserrat', sans-serif;
}
.navbar .getstarted {
	background: orange;
	margin-left: 30px;
	border-radius: 4px;
	font-weight: 400;
	color: #fff;
	text-decoration: none;
	padding: .5rem 1rem;
	line-height: 2.3;
}

.navbar-nav a {
	font-size: 15px;
	text-transform: uppercase;
	font-weight: 500;
}
.navbar-light .navbar-brand {
	color: #000;
	font-size: 25px;
	text-transform: uppercase;
	font-weight: bold;
	letter-spacing: 2px;
}
.navbar-light .navbar-brand:focus, .navbar-light .navbar-brand:hover {
	color: #000;
}
.navbar-light .navbar-nav .nav-link {
	color: #000;
}
.navbar-light .navbar-nav .nav-link:focus, .navbar-light .navbar-nav .nav-link:hover {
	color: #380000;
}
.w-100 {
	height: 100vh;
}
.navbar-toggler {
	padding: 1px 5px;
	font-size: 18px;
	line-height: 0.3;
	background: #fff;
}

@media only screen and (max-width: 767px) {
	.navbar-nav {
		text-align: center;
	}
}

</style>


<nav class="navbar navbar-expand-lg navbar-light bg-warning fixed-top">
    <div class="container">
        <!-- Swimming pool sys Logo -->
        <a class="navbar-brand text-success" href="../index.php">Delicious</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php
                
                if (isset($_SESSION['email'])) {
                    // If user is logged i
                    echo '<li class="nav-item">
                    <a class="nav-link" href="user.php">Userpannel</a>
                    </li>';
                    echo '<li class="nav-item">
                            <a class="nav-link" href="booking.php">Book A Slot</a>
                          </li>';
                    echo '<li class="nav-item">
                            <a class="nav-link" href="user.php">User Panel</a>
                          </li>';
                    echo '<li class="nav-item">
                            <a class="nav-link btn btn-danger text-light" href="logout.php">Log Out</a>
                          </li>';
                } else {
                    // If user is not logged in
                    echo '<li class="nav-item">
                            <a class="nav-link" href="../user/login.php">User</a>
                          </li>';
                   
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<!-- nav bar ends -->
