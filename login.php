<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Voting System</title>
    
    <?php include('./header.php'); ?>
    <?php 
    session_start();
    if (isset($_SESSION['login_id'])) {
        header("location:index.php?page=dashboard");
    }
    ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        body {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url(images/tmclog.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .login-container {
            width: 100%;
            margin-right: 900px;
            max-width: 400px;
            background: blur(2rem); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            backdrop-filter: blur(2px); /* Blurred effect */
            -webkit-backdrop-filter: blur(10px); /* For Safari */
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
            width: 100%;
        
        }
        label {
            font-weight: bold;
            color: white; /* Improves readability */
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.6);
            color: #000;
        }
        input::placeholder {
            color: #666;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
            margin-top: 10px;
        }
        button:hover {
            background: #0056b3;
        }
        .alert {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 style="color: #fdb515;">Admin Login</h2>
        <form id="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div id="error-message" class="alert" style="display: none;">Username or password is incorrect.</div>
    </div>

    <script>
        $('#login-form').submit(function(e){
            e.preventDefault();
            $('button[type="submit"]').attr('disabled', true).text('Logging in...');
            
            $.ajax({
                url: 'ajax.php?action=login',
                method: 'POST',
                data: $(this).serialize(),
                error: function(err) {
                    console.log(err);
                    $('button[type="submit"]').removeAttr('disabled').text('Login');
                },
                success: function(resp) {
                    if (resp == 1) {
                        window.location.href = 'index.php?page=dashboard';
                    } else if (resp == 2) {
                        window.location.href = 'voting.php';
                    } else {
                        $('#error-message').show();
                        $('button[type="submit"]').removeAttr('disabled').text('Login');
                    }
                }
            });
        });
    </script>
</body>
</html>
