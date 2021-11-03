<!-- Start Navr -->
<ul class="dashboard-nav">
  <li>Welcome, <?php echo $_SESSION['Username'] ?></li>
  <li class = "dashboard"><a  href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
  <li class = "products"><a href="items.php"><i class="fas fa-box-open"></i>Products</a></li>
  <li class = "clients"><a href="members.php?do=Manage"><i class="far fa-user"></i>Clients</a></li>
  <li class = "employee"><a href="employee.php?do=Manage"><i class="far fa-address-card"></i>Employee</a></li>
  <li class = "sections"><a href="sections.php?do=Manage"><i class="fab fa-audible"></i>Sections</a></li>
  <li class = "comments"><a href="comments.php"><i class="far fa-comment-dots"></i>Comments</a></li>
  <li class = "category"><a href="categories.php"><i class="far fa-bookmark"></i>Category</a></li>
  <li><a href="logout.php">LogOut</a></li>
</ul>
<!-- End Nav -->
