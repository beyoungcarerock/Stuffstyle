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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="public/Stuffstyle/cek.html";
  $loginUsername = $_POST['id_user'];
  $LoginRS__query = sprintf("SELECT id_user FROM `user` WHERE id_user=%s", GetSQLValueString($loginUsername, "int"));
  mysql_select_db($database_koneksi, $koneksi);
  $LoginRS=mysql_query($LoginRS__query, $koneksi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO `user` (id_user, user_name, email_user, password) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_user'], "int"),
                       GetSQLValueString($_POST['user_name'], "text"),
                       GetSQLValueString($_POST['email_user'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "berhasil.html";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html>
<html lang="en">

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
                    <li class="active"><a href="sign-up.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li>
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
                <h1 class="page-header">Sign Up
                </h1>
                <ol class="breadcrumb">
                    <li><a href="public/Stuffstyle/index.html">Home</a>
                    </li>
                    <li class="active">Sign Up</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="container-fluid">
    <section class="container">
    <div class="container-page">        
      <div action="<?php echo $editFormAction; ?>" class="col-md-6">
        <h3 class="dark-grey">Registration</h3>
<form method="post" name="form3" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">ID User :</td>
      <td><input class="form-control type="text" name="id_user" value="" size="32" placeholder="Angka 1-9" required></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">User Name :</td>
      <td><input class="form-control type="text" name="user_name" value="" size="32" placeholder="User Name" required></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email :</td>
      <td><input class="form-control type="text" name="email_user" value="" size="32" placeholder="tes@example.com" required></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Password :</td>
      <td><input class="form-control type="password" name="password" value="" size="32" placeholder="Pasword" required></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td>
      	<button type="submit" value="Daftar">Daftar</button>
        &nbsp;&nbsp;
        <button type="reset" value="Reset">Reset</button>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form3">
</form>
<p>&nbsp;</p>
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
