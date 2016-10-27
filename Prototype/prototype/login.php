<!DOCTYPE html>
<?php include "../Includes/layout_header.php";
//include "../Includes/db.php";
session_start();
$db = StoreDB::getInstance();
$location = isset($_GET['location']) ?  htmlspecialchars($_GET['location']) : "#";

if (count($_POST) > 0) {
    $username = isset($_POST['userName']) ? $_POST['userName'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    if ($_POST['id'] == "login") {
        if($db->verify_user($username, $password)) {
            $result = $db->get_name_from_username($username);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_row($result);
                $name = htmlentities($row[0]);                  
                $_SESSION['name'] = $name;
            }
            $_SESSION['username'] = $username;
            mysqli_free_result($result);
            header("Location: " . $location);
            exit;
            
        } else {
            echo "<div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                    Invalid username or password.  Try again.
                </div>";
        }      
    }
    else if ($_POST['id'] == "register") {
        if(!$db->insert_user($username, $password)) {
            echo "<div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                    That username is already selected. Try again.
                </div>";
        }
        else {
            // repeated -- make function
            $result = $db->get_name_from_username($username);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_row($result);
                $name = htmlentities($row['first_name']);                  
                $_SESSION['name'] = $name;
            }
            $_SESSION['username'] = $username;
            mysqli_free_result($result);
            header("Location: " . $location);
        }
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="jumbotron">
            <h2>Login or Register</h2>
                <p></p>
                <p>
                    <form method="post">
                      <div class="form-group">
                        <label for="userName">User Name</label>
                        <input type="text" class="form-control" name="userName" required placeholder="Enter user name here">
                      </div>
                      <div class="form-group">
                        <label for="password">Password (must be at least 5 characters)</label>
                        <input type="password" class="form-control" required name="password" placeholder="Password">
                      </div>
                      <button type="submit" name="id" value="login" class="btn btn-default">Login</button>
                      <button type="submit" name="id" value="register" class="btn btn-default">Register</button>
                    </form>
                </p>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
