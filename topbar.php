<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online School Voting System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* Navbar Styling */
        .navbar-custom {
            padding: 8px 16px; 
            background-color: darkblue;
        }

        /* Title & Logo Container */
        .navbar-brand-container {
            display: flex;
            align-items: center;
        }

        /* Logo Styling */
        .navbar-logo {
            height: 60px; 
            width: 60px; 
            margin-right: 10px; 
            border-radius: 50%;
        }

        /* Title Styling */
        .navbar-text-container {
            display: flex;
            flex-direction: column;
        }

        .navbar-title {
            color: gold;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin: 0;
        }

        .navbar-subtitle {
            color: white;
            font-size: 14px;
            margin: 0;
        }

        /* Logout Button Styling */
        .logout-button {
            font-size: 15px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .logout-button:hover {
            background-color: #c82333; /* Darker red on hover */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark fixed-top navbar-custom">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo & Title Section -->
        <div class="navbar-brand-container">
            <img src="images/TMC-Logo.png" alt="Logo" class="navbar-logo"> 
            <div class="navbar-text-container">
                <h4 class="navbar-title">Online School Voting System</h4>
                <p class="navbar-subtitle">Trinidad Municipal College</p>
            </div>
        </div>
        
        <!-- Logout Section -->
        <div class="d-flex align-items-center">
            <span class="text-warning font-weight-bold mr-3">
                <?php echo $_SESSION['login_name']; ?>
            </span>
            <a href="ajax.php?action=logout" class="btn btn-danger px-2 py-1 font-weight-bold logout-button">
                <i class="fa fa-power-off"></i>
            </a>
        </div>

    </div>
</nav>

</body>
</html>
