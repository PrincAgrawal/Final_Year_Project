<?php    
define('TITLE', 'Update Technician');
define('PAGE', 'technician');
include('includes/header.php'); 
include('../dbConnection.php');
session_start();
 if(isset($_SESSION['is_adminlogin'])){
  $aEmail = $_SESSION['aEmail'];
 } else {
  echo "<script> location.href='login.php'; </script>";
 }
 if(isset($_REQUEST['empsubmit'])){
  if(($_REQUEST['empName'] == "") || ($_REQUEST['empCity'] == "") || ($_REQUEST['empMobile'] == "") || ($_REQUEST['empEmail'] == "")){
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
   $eName = $_REQUEST['empName'];
   $eCity = $_REQUEST['empCity'];
   $eMobile = $_REQUEST['empMobile'];
   $eEmail = $_REQUEST['empEmail'];

   // Validate mobile number (10 digits)
   if(!preg_match('/^[0-9]{10}$/', $eMobile)) {
     $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Mobile number must be 10 digits</div>';
   }
   // Validate email DNS
   else if(!filter_var($eEmail, FILTER_VALIDATE_EMAIL)) {
     $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Invalid email format</div>';
   }
   else if(!checkdnsrr(explode('@', $eEmail)[1], 'MX')) {
     $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Invalid email domain</div>';
   }
   else {
     $sql = "INSERT INTO technician_tb (empName, empCity, empMobile, empEmail) VALUES ('$eName', '$eCity','$eMobile', '$eEmail')";
     if($conn->query($sql) == TRUE){
       $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Added Successfully </div>';
     } else {
       $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add </div>';
     }
   }
  }
}
?>
<!-- Start 2nd Column -->
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New Technician</h3>
  <form action="" method="POST" onsubmit="return validateForm()">
    <div class="form-group">
      <label for="empName">Name</label>
      <input type="text" class="form-control" id="empName" name="empName">
    </div>
    <div class="form-group">
      <label for="empCity">City</label>
      <input type="text" class="form-control" id="empCity" name="empCity">
    </div>
    <div class="form-group">
      <label for="empMobile">Mobile</label>
      <input type="text" class="form-control" id="empMobile" name="empMobile" maxlength="10" onkeypress="return isInputNumber(event)" placeholder="10 digits mobile number">
      <small class="form-text text-muted">Enter 10 digit mobile number</small>
    </div>
    <div class="form-group">
      <label for="empEmail">Email</label>
      <input type="email" class="form-control" id="empEmail" name="empEmail">
      <small class="form-text text-muted">Enter a valid email address</small>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="empsubmit" name="empsubmit">Submit</button>
      <a href="technician.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>

<script>
  // Only allow numbers in mobile field
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
      return false;
    }
    return true;
  }

  // Form validation
  function validateForm() {
    var mobile = document.getElementById('empMobile').value;
    var email = document.getElementById('empEmail').value;
    
    // Validate mobile number
    if(mobile.length !== 10) {
      alert('Mobile number must be 10 digits');
      return false;
    }

    // Basic email validation
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailPattern.test(email)) {
      alert('Please enter a valid email address');
      return false;
    }

    return true;
  }
</script>
<?php include('includes/footer.php'); ?>
