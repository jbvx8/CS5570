<?php

if(!isset($_SESSION['cart_products'])) {
    $_SESSION['cart_products'] = array();
} 
if(isset($_GET['logout'])) {
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    if (isset($_SESSION['customer'])) { unset($_SESSION['customer']); }
    if (isset($_SESSION['name'])) { unset($_SESSION['name']); }
    $url = str_replace("?logout=true", "", $_SERVER["REQUEST_URI"]);
    header("Location: " . $url);
    die();
}
?>

<nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="store.php">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <!-- fix links -->
        
        <li class="active">
            <a href="cart.php">
                <?php 
                $count=0;
                foreach($_SESSION["cart_products"] as $quantity => $value) {
                    $count += $value;
                }
                ;?>
                Cart <span class='badge' id="comparison-count"><?php echo $count;?></span>
            </a>
        </li>
        <li class="active"><a href="checkout.php">Checkout </a></li>
      </ul>
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
          <?php if (!isset($_SESSION['username'])) { ?>
              <li><a href="<?php echo "../prototype/login.php?location=" . urlencode($_SERVER['REQUEST_URI']);?>">Login</a></li>
              <li><a href="<?php echo "../prototype/login.php?location=" . urlencode($_SERVER['REQUEST_URI']);?>">Register</a></li>
          <?php } else { 
              if (isset($_SESSION['name'])) { 
                  echo "<li><p class='navbar-text'>Welcome, " . $_SESSION['name'] . "!</p></li>";
              }
              else {
                  echo "<li><p class='navbar-text'>Welcome, " . $_SESSION['username'] . "!</p></li>";
              } ?>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="../prototype/user_orders.php">Orders</a></li>
                    <li><a href="user_edit.php">Settings</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="?logout=true">Logout</a></li>
                  </ul>
              </li>
              <li><a href="?logout=true">Logout</a></li>
          <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div>
</nav>

