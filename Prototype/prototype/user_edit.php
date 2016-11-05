<?php 
session_start();

$page_title="Edit Customer Details";
include '../Includes/layout_header.php';
$db = StoreDB::getInstance();

$customer = $_SESSION["customer"]; 

$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : "";
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : "";

switch($action){ 
    case 'exception': ?>
        <div class='alert alert-danger alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            <strong><?php echo $message ?></strong>
        </div>
<?php break;
    case 'success': ?>
        
        <div class='alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick="history.go(-2);return false;">
                OK
             </button>
            Customer successfully updated!
        </div>
<?php break;
    case 'changePassword':
        $new = isset($_POST['newPassword']) ? $_POST['newPassword'] : "";
        $confirm = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : "1";
        if ($new == $confirm) {
            try {
                $username = $_SESSION['username'];
                $db->change_password($username, $new);
                header("Location: ?action=success");
            } catch (Exception $ex) {
                header("Location: ?action=exception&message=" . $ex->getMessage());
            }           
        } else {
            header("Location: ?action=exception&message=Both values must match.");
        }
    }
?>

<form class="form-horizontal bottom-pad-50" method="post" action="order_process.php?action=update" id="editForm">
    <div class="form-group">      
      <div class="col-md-4">
        <label for="inputFirst">First Name</label>
        <input type="text" class="form-control" id="inputFirst" name="inputFirst" value="<?php echo $customer['firstName'];?>">
      </div>
      <div class="col-md-4">
        <label for="inputLast">Last Name</label>
        <input type="text" class="form-control" id="inputLast" name="inputLast" value="<?php echo $customer['lastName'];?>">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-8">
        <label for="inputAddress1">Address Line 1</label>
        <input type="text" class="form-control" id="inputAddress1" name="inputAddress1" value="<?php echo $customer['addressLine1'];?>">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-8">
        <label for="inputAddress2">Address Line 2</label>
        <input type="text" class="form-control" id="inputAddress2" name="inputAddress2" value="<?php echo $customer['addressLine2'];?>">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-3">
        <label for="inputCity">City</label>
        <input type="text" class="form-control" id="inputCity" name="inputCity" value="<?php echo $customer['city'];?>">
      </div>
      <div class="col-md-2">
        <label for="inputState">State</label>
        <?php $selected = $customer['state']; ?>
        <select class="form-control" id="inputState" name="inputState">
            <option <?php if ($selected == "AK"){echo("selected");}?> value="AK">Alaska</option>
            <option <?php if ($selected == "AL"){echo("selected");}?>value="AL">Alabama</option>
            <option <?php if ($selected == "AR"){echo("selected");}?>value="AR">Arkansas</option>
            <option <?php if ($selected == "AZ"){echo("selected");}?>value="AZ">Arizona</option>
            <option <?php if ($selected == "CA"){echo("selected");}?>value="CA">California</option>
            <option <?php if ($selected == "CO"){echo("selected");}?>value="CO">Colorado</option>
            <option <?php if ($selected == "CT"){echo("selected");}?>value="CT">Connecticut</option>
            <option <?php if ($selected == "DC"){echo("selected");}?>value="DC">District of Columbia</option>
            <option <?php if ($selected == "DE"){echo("selected");}?>value="DE">Delaware</option>
            <option <?php if ($selected == "FL"){echo("selected");}?>value="FL">Florida</option>
            <option <?php if ($selected == "GA"){echo("selected");}?>value="GA">Georgia</option>
            <option <?php if ($selected == "HI"){echo("selected");}?>value="HI">Hawaii</option>
            <option <?php if ($selected == "IA"){echo("selected");}?>value="IA">Iowa</option>
            <option <?php if ($selected == "ID"){echo("selected");}?>value="ID">Idaho</option>
            <option <?php if ($selected == "IL"){echo("selected");}?>value="IL">Illinois</option>
            <option <?php if ($selected == "IN"){echo("selected");}?>value="IN">Indiana</option>
            <option <?php if ($selected == "KS"){echo("selected");}?>value="KS">Kansas</option>
            <option <?php if ($selected == "KY"){echo("selected");}?>value="KY">Kentucky</option>
            <option <?php if ($selected == "LA"){echo("selected");}?>value="LA">Louisiana</option>
            <option <?php if ($selected == "MA"){echo("selected");}?>value="MA">Massachusetts</option>
            <option <?php if ($selected == "MD"){echo("selected");}?>value="MD">Maryland</option>
            <option <?php if ($selected == "ME"){echo("selected");}?>value="ME">Maine</option>
            <option <?php if ($selected == "MI"){echo("selected");}?>value="MI">Michigan</option>
            <option <?php if ($selected == "MN"){echo("selected");}?>value="MN">Minnesota</option>
            <option <?php if ($selected == "MO"){echo("selected");}?> value="MO">Missouri</option>
            <option <?php if ($selected == "MS"){echo("selected");}?>value="MS">Mississippi</option>
            <option <?php if ($selected == "MT"){echo("selected");}?>value="MT">Montana</option>
            <option <?php if ($selected == "NC"){echo("selected");}?>value="NC">North Carolina</option>
            <option <?php if ($selected == "ND"){echo("selected");}?>value="ND">North Dakota</option>
            <option <?php if ($selected == "NE"){echo("selected");}?>value="NE">Nebraska</option>
            <option <?php if ($selected == "NH"){echo("selected");}?>value="NH">New Hampshire</option>
            <option <?php if ($selected == "NJ"){echo("selected");}?>value="NJ">New Jersey</option>
            <option <?php if ($selected == "NM"){echo("selected");}?>value="NM">New Mexico</option>
            <option <?php if ($selected == "NV"){echo("selected");}?>value="NV">Nevada</option>
            <option <?php if ($selected == "NY"){echo("selected");}?>value="NY">New York</option>
            <option <?php if ($selected == "OH"){echo("selected");}?>value="OH">Ohio</option>
            <option <?php if ($selected == "OK"){echo("selected");}?>value="OK">Oklahoma</option>
            <option <?php if ($selected == "OR"){echo("selected");}?>value="OR">Oregon</option>
            <option <?php if ($selected == "PA"){echo("selected");}?>value="PA">Pennsylvania</option>
            <option <?php if ($selected == "PR"){echo("selected");}?>value="PR">Puerto Rico</option>
            <option <?php if ($selected == "RI"){echo("selected");}?>value="RI">Rhode Island</option>
            <option <?php if ($selected == "SC"){echo("selected");}?>value="SC">South Carolina</option>
            <option <?php if ($selected == "SD"){echo("selected");}?>value="SD">South Dakota</option>
            <option <?php if ($selected == "TN"){echo("selected");}?>value="TN">Tennessee</option>
            <option <?php if ($selected == "TX"){echo("selected");}?>value="TX">Texas</option>
            <option <?php if ($selected == "UT"){echo("selected");}?>value="UT">Utah</option>
            <option <?php if ($selected == "VA"){echo("selected");}?>value="VA">Virginia</option>
            <option <?php if ($selected == "VT"){echo("selected");}?>value="VT">Vermont</option>
            <option <?php if ($selected == "WA"){echo("selected");}?>value="WA">Washington</option>
            <option <?php if ($selected == "WI"){echo("selected");}?>value="WI">Wisconsin</option>
            <option <?php if ($selected == "WV"){echo("selected");}?>value="WV">West Virginia</option>
            <option <?php if ($selected == "WY"){echo("selected");}?>value="WY">Wyoming</option>
        </select>	
      </div>
      <div class="col-md-3">
        <label for="inputZip">Zip Code</label>
        <input type="text" class="form-control" id="inputZip" name="inputZip" value="<?php echo $customer['zip'];?>" pattern="[0-9]{5}|[0-9]{9}" required title="Not a valid zip code">
      </div>
    </div>
    <div class="form-group">      
      <div class="col-md-4">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?php echo $customer['email'];?>">
      </div>
      <div class="col-md-4">
        <label for="inputPhone">Phone Number</label>
        <input type="tel" class="form-control" id="inputPhone" name="inputPhone" value="<?php echo $customer['phone'];?>">
      </div>
    </div>
    <input type="submit" class="btn btn-primary">
    <button class="btn btn-default" onclick="history.go(-1);return false;">Cancel</button>
</form>

<h1 class="top-pad-50">Change Password</h1>
<hr>
<form class="form-horizontal top-pad-50 bottom-pad-50" method="post" action="order_process.php?action=verifyPassword">
    <div class="form-group" id="oldPassword">  
        <label for="oldPassword">Current Password</label>
        <div class="col-md-4" id="currentP">        
            <input type="password" class="form-control" id="oldPassword" name="oldPassword">
        </div>
    </div>
</form>
    <?php 
    if ($action == 'userVerified') { 
         ?>
      <script > 
          hideDiv("oldPassword");         
      </script>
      <form class="form-horizontal top-pad-50 bottom-pad-50" method="post" action="?action=changePassword">
          <div class="form-group">
            <label for="newPassword">New Password</label>
            <div class="col-md-4">                
                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password.">
            </div>
          </div>
          <div class="form-group">
            <label for="confirmPassword">Confirm New Password</label>
            <div class="col-md-4">        
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Retype new password.">
            </div>      
          </div>
          <button type="submit" class="btn btn-primary">Confirm change</button>
      </form>
    <?php } ?>
   
      
      






