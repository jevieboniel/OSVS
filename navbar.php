<style>
    #sidebar {
        background-color: black; /* Light gray background */
        padding: 10px;
        width: 250px;
        height: 100vh;
		margin-top: 20px;
    }

    .sidebar-list {
        display: flex;
        flex-direction: column;
        gap: 10px; /* Added gap between items */
    }

    .sidebar-list a {
        display: block;
        padding: 15px 15px;
        color: black; /* Ensures text is readable */
        text-decoration: none;
        font-size: 16px;
        border-radius: 5px;
        transition: background 0.3s;
        
    }

    .sidebar-list a:hover, .sidebar-list a.active {
        background-color: gray; /* Slightly darker gray for hover and active */
        color: white;
		text-decoration: none;
    }

    .icon-field {
        margin-right: 10px;
    }
</style>

<nav id="sidebar">
    <div class="sidebar-list ">
        <a href="index.php?page=dashboard" class="nav-item bg-primary nav-home">
            <span class='icon-field'></i></span> Dashboard
        </a>
        <a href="index.php?page=categories" class="nav-item bg-primary nav-categories">
            <span class='icon-field'></span> Categories
        </a>
        <a href="index.php?page=voting_list" class="nav-item bg-primary nav-voting_list nav-manage_voting">
            <span class='icon-field'></i></span> Candidates
        </a>
        <a href="index.php?page=reports" class="nav-item bg-primary nav-voting_list nav-manage_voting">
            <span class='icon-field'></i></span> Reports
        </a>
		
        <?php if($_SESSION['login_type'] == 1): ?>
            <a href="index.php?page=users" class="nav-item bg-primary nav-users">
                <span class='icon-field'></i></span> Users
            </a>
        <?php endif; ?>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let activePage = "<?php echo isset($_GET['page']) ? $_GET['page'] : ''; ?>";
        if (activePage) {
            document.querySelector('.nav-' + activePage)?.classList.add('active');
        }
    });
</script>
