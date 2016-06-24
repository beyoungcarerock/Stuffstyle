<?php require_once('Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['id_user'])) {
  $loginUsername=$_POST['id_user'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "gagal.html";
  $MM_redirectLoginFailed = "sukses.html";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_koneksi, $koneksi);
  
  $LoginRS__query=sprintf("SELECT id_user, user_name FROM `user` WHERE id_user=%s AND user_name=%s",
    GetSQLValueString($loginUsername, "int"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $koneksi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="public/Stuffstyle/images/header.jpg">
    <title>Stuffstyle</title>
    <link href="public/Stuffstyle/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/Stuffstyle/css/style.css" rel="stylesheet">
    <link href="public/Stuffstyle/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="public/Stuffstyle/css/footer-distributed-with-address-and-phones.css">
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
</head>


<body>
<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="public/Stuffstyle/index.html">STUFFSTYLE</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <div class="col-lg-6">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Cari Produk, Kategori, Atau Merk">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Cari</button>
                      </span>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="public/Stuffstyle/index.html">Home</a>
                    </li>
                    <li>
                        <a href="public/Stuffstyle/contact.html">Contact</a>
                    </li>
                    <li ><a href="public/Stuffstyle/cart.html"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
                    <li><a href="sign-up.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li class="active">
                        <a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login<strong class="caret"></strong></a>
                    </li>
                     </ul>
                  </div>
                    </li>
                </ul>
      </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Login
                </h1>
                <ol class="breadcrumb">
                    <li><a href="public/Stuffstyle/index.html">Home</a>
                    </li>
                                <li class="active">Login</li>
    </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="container-fluid">
    <section class="container">
    <div class="container-page">        
      <div action="<?php echo $editFormAction; ?>" class="col-md-6">
        <h3 class="dark-grey">Login</h3>


<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST">
	<table>
    	<tr>
            <td><label for="id_user">Id User : </label></td>
            <td><input type="text" name="id_user" placeholder="Id User" required/></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
            <td><label for="password">Password : </label></td>
            <td><input type="password" name="password" placeholder="Pasword" required/></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
       	  <td colspan="2"><button type="submit">Login</button></td>
        </tr>
	</table>
</form>
	
    </div>
    
      <div class="col-md-6">
        <h3 class="dark-grey">Terms and Conditions</h3>
        <p>
          By clicking on "Register" you agree to The Stuffstyle's Terms and Conditions
        </p>
        <p>
          While rare, prices are subject to change based on exchange rate fluctuations - 
          should such a fluctuation happen, we may request an additional payment. You have the option to request a full refund or to pay the new price.
        </p>
        <p>
          Should there be an error in the description or pricing of a product, we will provide you with a full refund
        </p>
        <p>
          Acceptance of an order by us is dependent on our suppliers ability to provide the product.
        </p>
        
        <button type="submit" class="btn btn-primary" name="register">Register</button>
      </div>
    </div>
  </section>
</div>
    </div>
    <!-- /.container -->
<!--footer-->
        <footer class="footer-distributed">
              <div class="footer-left">
                <h3>Stuff<span>Style</span></h3>
                <p class="footer-links">
                  <a href="#">Home</a>
                  ·
                  <a href="#">Blog</a>
                  ·
                  <a href="#">Pricing</a>
                  ·
                  <a href="#">About</a>
                  ·
                  <a href="#">Faq</a>
                  ·
                  <a href="#">Contact</a>
                </p>
                <p class="footer-company-name">StuffStyle &copy; 2015</p>
              </div>
              <div class="footer-center">
                <div>
                  <i class="fa fa-map-marker"></i>
                  <p><span>21 Revolution Street</span> Medan, Indonesia</p>
                </div>
                <div>
                  <i class="fa fa-phone"></i>
                  <p>+62 812 6205 2292</p>
                </div>
                <div>
                  <i class="fa fa-envelope"></i>
                  <p><a href="mailto:support@company.com">support@stuffstyle.com</a></p>
                </div>
              </div>
              <div class="footer-right">
                <p class="footer-company-about">
                  <span>About the company</span>
                  We Sell Fashion Product, With Best Brand as we Trust To Customer.
                </p>
                <div class="footer-icons">
                  <a href="#"><i class="fa fa-facebook"></i></a>
                  <a href="#"><i class="fa fa-twitter"></i></a>
                  <a href="#"><i class="fa fa-linkedin"></i></a>
                  <a href="#"><i class="fa fa-github"></i></a>
                </div>
              </div>
        </footer>
    <!-- jQuery -->
<script src="public/Stuffstyle/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
<script src="public/Stuffstyle/js/bootstrap.min.js"></script>

</body>
</html>