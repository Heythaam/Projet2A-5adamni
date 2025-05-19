<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>5adamni</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <?php
    require_once "../../../config/connexion.php";
    require_once "../../../Controller/UserController.php";
    session_start();
    if(!isset($_SESSION['id'])) {
        header("location: login.php");
        exit;
    }
    else {
        $usrc=new UserC();
        $user=$usrc->GetUserById($_SESSION['id']);
        if($user['role']=="Admin"){
            echo '<script>';
            echo 'document.addEventListener("DOMContentLoaded", function() {';
            echo '    var prenom = "' . htmlspecialchars($_SESSION['prenom']) . '";';
            echo '    var users = document.getElementsByClassName("user");';
            echo '    for (var i = 0; i < users.length; i++) {';
            echo '        users[i].textContent = prenom;';
            echo '    }';
            echo '});';
            echo '</script>';
        }
        else{
            if($user['role']=="Postulant"){
                header("location: ../FrontOffice/Postulant/");
            }
            else{
                header("location: ../FrontOffice/Entreprise/");
            }
        }
    }
        include '../../../Controller/PostsC.php';
        include '../../../Controller/CommentsC.php';
        include '../../../Model/Posts.php';
        include '../../../Model/Comments.php';
        $pdo=openDB();
        $table=$pdo->query("Select * from posts");
        $table1=$pdo->query("Select * from comments");
        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    switch ($sort) {
        case 'comments':
            // Sort comments by Time descending
            $query = $pdo->prepare('SELECT * FROM comments ORDER BY Time ASC');
            break;
        default:
            // Default query if no sort parameter provided or invalid parameter
            $query = $pdo->prepare('SELECT * FROM comments');
            break;
    }

    // Execute the query
    $query->execute();
    $sortedComments = $query->fetchAll();
    ?>

    <!-- Favicon -->
    <link href="../logo-mini.svg" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="../index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><img src="../logo.svg"></h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="../img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">User</h6>
                        <span>Admin</span>  
                    </div>
                </div>
                <div class="navbar-nav w-100">  
                    <div class="ms-3">
                        <span>Navigation</span>
                    </div>
                    <br>
                    <a href="../index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="../users/users.php" class="nav-item nav-link"><i class="fa bi-people-fill me-2"></i>Users</a>
                    <a href="../offres/offres.php" class="nav-item nav-link"><i class="fa bi-megaphone-fill me-2"></i>Offres</a>
                    <a href="../entretiens/entretiens.php" class="nav-item nav-link"><i class="fa bi-calendar-event-fill me-2"></i>Entretiens</a>
                    <a href="postes.php" class="nav-item nav-link active"><i class="fa bi-pen-fill me-2"></i>Postes</a>
                    <a href="../competences/cv.php" class="nav-item nav-link"><i class="fa bi-file-text-fill me-2"></i>Compétences</a>
                    <a href="../reclamations/reclamations.php" class="nav-item nav-link"><i class="fa bi-exclamation-octagon-fill me-2"></i>Reclamations</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="../index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Mails</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="../img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="../img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="../img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notifications</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="../img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">User</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- 404 Start -->
            <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Posts List</h6>
                        <a href="?sort=posts"><i class="bi-sort-numeric-down"></i></a>
                    </div>
                    <button class="btn btn-primary" onclick="sortTableByTimestamp('table-tr')">Sort Posts</button>
                    <form class="d-none d-md-flex ms-4" action="postes.php" method="post">
                    <input id="searchInput" oninput="searchTable()" class="form-control bg-dark border-0" type="search" placeholder="Search">
                    <script>
                            function searchTable() {
                                var input, filter, table, tr, td, i, txtValue;
                                input = document.getElementById("searchInput");
                                filter = input.value.toUpperCase();
                                table = document.getElementById("table-tr");
                                tr = table.getElementsByTagName("tr");

                                // Loop through all table rows, and hide those who don't match the search query
                                for (i = 0; i < tr.length; i++) {
                                    td = tr[i].getElementsByTagName("td");
                                    for (var j = 0; j < td.length; j++) {
                                        var cell = td[j];
                                        if (cell) {
                                            txtValue = cell.textContent || cell.innerText;
                                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                tr[i].style.display = "";
                                                break;
                                            } else {
                                                tr[i].style.display = "none";
                                            }
                                        }
                                    }
                                }
                            }
                            function sortTableByTimestampDesc(tableId) {
                                var table, rows, switching, i, x, y, shouldSwitch;
                                table = document.getElementById(tableId);
                                switching = true;
                                /* Make a loop that will continue until
                                no switching has been done: */
                                while (switching) {
                                    // Start by saying: no switching is done:
                                    switching = false;
                                    rows = table.rows;
                                    /* Loop through all table rows (except the
                                    first, which contains table headers): */
                                    for (i = 1; i < (rows.length - 1); i++) {
                                        // Start by saying there should be no switching:
                                        shouldSwitch = false;
                                        /* Get the two elements you want to compare,
                                        one from the current row and one from the next: */
                                        x = rows[i].getElementsByTagName("TD")[1]; // Assuming timestamp is in the second column
                                        y = rows[i + 1].getElementsByTagName("TD")[1]; // Assuming timestamp is in the second column
                                        /* Check if the two rows should switch place,
                                        based on the timestamp in the second column: */
                                        if (new Date(x.textContent) < new Date(y.textContent)) {
                                            // If so, mark as a switch and break the loop:
                                            shouldSwitch = true;
                                            break;
                                        }
                                    }
                                    if (shouldSwitch) {
                                        /* If a switch has been marked, make the switch
                                        and mark that a switch has been done: */
                                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                                        switching = true;
                                    }
                                }
                            }





                    </script>
                    <button type="submit">Search</button>
                    </form> <br>
                    <div class="table-responsive">
                        <table id="table-tr" class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">Author</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">MediaData</th>
                                    <th scope="col">Delete Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($rows=$table->fetch()){
                                    $PostID = $rows['PostID'];
                                    $author=$rows['Author'];
                                    $time=$rows['Time'];
                                    $content=$rows['Content'];
                                    $MediaData=$rows['MediaData'];
                                ?>
                                <tr>
                                    <td><?php echo $author;?></td>
                                    <td><?php echo $time;?></td>
                                    <td><?php echo $content;?></td>
                                    <td><?php echo $MediaData;?></td>
                                    <td><button class="btn btn-sm btn-primary"><?php echo'<a href="users.php?cin='. $PostID .'"style="text-decoration: none;color: white;"">Delete</a>'?></button></td>
                                </tr>
                                <?php
                                    }
                                    if(isset($_GET["cin"])){
                                        echo '<script>';
                                        echo '    var cin = "' . htmlspecialchars($_GET["cin"]) . '";';
                                        echo 'var result = confirm("Do you want to delete the user: "+cin+"?");';
                                        echo 'if (result) {';
                                        echo '    window.location.href = "delete.php?cin=' . $_GET["cin"] . '&confirmed=true";';
                                        echo '} else {';
                                        echo '    window.location.href = "users.php";';
                                        echo '}';
                                        echo '</script>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div> <br>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Comments List</h6>
                        <button id="sortButton" class="btn btn-primary" onclick="sortTableByTimestamp()">Sort Comments</button>
                        <form id="sortForm" method="GET" action="">
                        <input type="hidden" name="sort" id="sortInput">
                        </form>
                    </div>
                    <form class="d-none d-md-flex ms-4" method="POST" action="recherche.php">
                    <input id="searchInput" oninput="searchTable()" class="form-control bg-dark border-0" type="search" placeholder="Search">
                    <script>
                            function searchTable() {
                                var input, filter, table, tr, td, i, txtValue;
                                input = document.getElementById("searchInput");
                                filter = input.value.toUpperCase();
                                table = document.getElementById("table-tr");
                                tr = table.getElementsByTagName("tr");

                                // Loop through all table rows, and hide those who don't match the search query
                                for (i = 0; i < tr.length; i++) {
                                    td = tr[i].getElementsByTagName("td");
                                    for (var j = 0; j < td.length; j++) {
                                        var cell = td[j];
                                        if (cell) {
                                            txtValue = cell.textContent || cell.innerText;
                                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                tr[i].style.display = "";
                                                break;
                                            } else {
                                                tr[i].style.display = "none";
                                            }
                                        }
                                    }
                                }
                            }
                            function sortTableByTimestamp() {
                            var table, rows, switching, i, x, y, shouldSwitch;
                            table = document.getElementById("table-tr");
                            switching = true;
                            /* Make a loop that will continue until
                            no switching has been done: */
                            while (switching) {
                                // Start by saying: no switching is done:
                                switching = false;
                                rows = table.rows;
                                /* Loop through all table rows (except the
                                first, which contains table headers): */
                                for (i = 1; i < (rows.length - 1); i++) {
                                    // Start by saying there should be no switching:
                                    shouldSwitch = false;
                                    /* Get the two elements you want to compare,
                                    one from current row and one from the next: */
                                    x = rows[i].getElementsByTagName("TD")[0];
                                    y = rows[i + 1].getElementsByTagName("TD")[0];
                                    /* Check if the two rows should switch place,
                                    based on the timestamp in the first column: */
                                    if (new Date(x.textContent) < new Date(y.textContent)) {
                                        // If so, mark as a switch and break the loop:
                                        shouldSwitch = true;
                                        break;
                                    }
                                }
                                if (shouldSwitch) {
                                    /* If a switch has been marked, make the switch
                                    and mark that a switch has been done: */
                                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                                    switching = true;
                                }
                            }
                        }


                    </script>
                    </form> <br>
                    <div class="table-responsive">
                        <table id="table-tr" class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">Author</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Delete Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($rows=$table1->fetch()){
                                    $CommentID = $rows['CommentID'];
                                    $author1=$rows['Author'];
                                    $time1=$rows['Timestamp'];
                                    $content1=$rows['content'];
                                ?>
                                <tr>
                                    <td><?php echo $author1;?></td>
                                    <td><?php echo $time1;?></td>
                                    <td><?php echo $content1;?></td>
                                    <td><button class="btn btn-sm btn-primary"><?php echo'<a href="users.php?cin='. $CommentID .'"style="text-decoration: none;color: white;"">Delete</a>'?></button></td>
                                </tr>
                                <?php
                                    }
                                    if(isset($_GET["cin"])){
                                        echo '<script>';
                                        echo '    var cin = "' . htmlspecialchars($_GET["cin"]) . '";';
                                        echo 'var result = confirm("Do you want to delete the user: "+cin+"?");';
                                        echo 'if (result) {';
                                        echo '    window.location.href = "delete.php?cin=' . $_GET["cin"] . '&confirmed=true";';
                                        echo '} else {';
                                        echo '    window.location.href = "users.php";';
                                        echo '}';
                                        echo '</script>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- 404 End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">5adamni</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Developed By <a href="https://ByteQuest.tn">ByteQuest</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/chart/chart.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>