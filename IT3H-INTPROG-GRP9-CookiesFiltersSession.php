<?php
    session_start(); // Start session

    // kapag pinindot yung submit button
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        if (isset($_COOKIE['name'])) { // Clear existing cookies 
            setcookie('name', '', time() - 3600, "/"); 
        }
        
        // initialization ng inputs
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
        // Validation sa email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // ipapasok sa session yung variables
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
    
            // Set ng cookie kasama yung name, na nag-eexpire in 30 days
            setcookie('name', $name, time() + (86400 * 30), "/"); // 86400 = 1 day
    
            $message = "Form submitted successfully!";
        } else {
            $message = "Invalid email address.";
        }
    }
    // Retrieve name from cookie kung na set na
    $savedName = isset($_COOKIE['name']) ? $_COOKIE['name'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./design.css">
    <title>GRP9 PHP Form with Cookies, Filters, and Sessions</title>
</head>
<body>
    <div class="cfs-body">

        <div class="cfs-header">
            <div class="left-side">
                <h3>GRP9</h3>
            </div>
            <img class="right-side" src="./close-btn-png.png" alt="">   
        </div>
        <br><br><br>
        <div class="cfs-cont">
            <h2 class="cfs-h2-signup-title">Sign Up Form Beta</h2>

            <div class="cfs-cont-formbox">
                <?php if (isset($message)) echo "<p>$message</p>"; ?>
                <br>
                <form method="post" action="">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required><br>
                    <br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>
                    <br>
                    <button class="submit-btn" type="submit">Submit</button>
                </form>
                <br>
                <?php if (isset($_SESSION['name']) && isset($_SESSION['email'])): ?>
                    <h3>Session Data  Retrieved:</h3>
                    <br>
                    <p><b>Name:</b> <u><?php echo htmlspecialchars($_SESSION['name']); ?></u></p>
                    <p><b>Email:</b> <u><?php echo htmlspecialchars($_SESSION['email']); ?></u></p>
                <?php endif; ?> 
            </div>

        </div>
    </div>
</body>
</html>
