<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>ADMIN LOGIN</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="<?= base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url();?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url();?>/assets/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="<?= base_url();?>/assets/css/style.css" rel="stylesheet" type="text/css">
<link href="<?= base_url();?>/assets/css/pages/signin.css" rel="stylesheet" type="text/css">

<!-- Software-like Login Page Design -->
<style>
  body {
    background: #e3f2fd;
    min-height: 100vh;
    margin: 0;
    font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
  }
  .app-header {
    background: linear-gradient(90deg, #1976d2 0%, #64b5f6 100%);
    color: #fff;
    padding: 18px 0;
    text-align: center;
    font-size: 1.6rem;
    font-weight: 700;
    letter-spacing: 1px;
    box-shadow: 0 2px 8px rgba(33,150,243,0.08);
    margin-bottom: 32px;
  }
  .login-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 70vh;
  }
  .login-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 24px rgba(33,150,243,0.10);
    padding: 38px 32px 32px 32px;
    max-width: 380px;
    width: 100%;
    margin: 0 auto;
    position: relative;
  }
  .login-card h2 {
    color: #1976d2;
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 18px;
    text-align: center;
    letter-spacing: 0.5px;
  }
  .login-card label {
    font-weight: 500;
    color: #1976d2;
    margin-bottom: 6px;
    display: block;
    font-size: 1rem;
  }
  .login-card input[type="text"],
  .login-card input[type="password"] {
    width: 90%;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #bbdefb;
    margin-bottom: 18px;
    font-size: 1rem;
    background: #f4f6fb;
    transition: border 0.2s;
  }
  .login-card input[type="text"]:focus,
  .login-card input[type="password"]:focus {
    border-color: #1976d2;
    outline: none;
  }
  .login-card input[type="submit"] {
    width: 100%;
    background: linear-gradient(90deg, #1976d2 0%, #64b5f6 100%);
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 8px;
  }
  .login-card input[type="submit"]:hover {
    background: linear-gradient(90deg, #1565c0 0%, #1976d2 100%);
  }
  .login-card .error {
    color: #d32f2f;
    margin-bottom: 12px;
    text-align: center;
  }
</style>
</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand">
				<!--<img  style="width:150px !important" src="<?= base_url();?>/assets/img/logo.png"   />			-->
				
				ERP LOGIN
			</a>		
			
			<!--<div class="nav-collapse">
				<ul class="nav pull-right">
					
					<li class="">						
						<a href="signup.html" class="">
							Don't have an account?
						</a>
						
					</li>
					
					<li class="">						
						<a href="index.html" class="">
							<i class="icon-chevron-left"></i>
							Back to Homepage
						</a>
						
					</li>
				</ul>
				
			</div>--><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->

  

<div class="app-header">ERP System Login</div>
<div class="login-container">
  <div class="login-card">
    <h2>Sign in to your account</h2>
    <?php if(isset($message) && $message): ?>
      <div class="error"><?php echo $message; ?></div>
    <?php endif; ?>
    <?php echo form_open("admin/auth/login");?>
      <div style="display:flex;flex-direction:column;gap:12px;">
        <label for="identity">Username</label>
        <?php echo form_input($identity);?>
        <label for="password">Password</label>
        <?php echo form_input($password);?>
        <input type="submit" value="Login" style="margin-top:8px;">
      </div>
    <?php echo form_close();?>
  </div>
</div>

  
<!--<div class="login-extra">
	<a href="#">Reset Password</a>
</div>--> <!-- /login-extra -->


<script src="<?= base_url();?>/assets/js/jquery-1.7.2.min.js"></script>
<script src="<?= base_url();?>/assets/js/bootstrap.js"></script>

<script src="<?= base_url();?>/assets/js/signin.js"></script>

</body>

</html>


