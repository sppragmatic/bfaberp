<div class="main">

  <div class="main-inner">

    <div class="container">

	  <div class="row">

	 <div class="span12">

	  	<div class="widget ">

	      			

	      			<div class="widget-header">

	      				<i class="icon-user"></i>

	      				<h3>Change Password</h3>

	  				</div> <!-- /widget-header -->

					

					<div class="widget-content">

<!-- Centralized Change Password Design -->
<style>
  .change-password-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 70vh;
    background: #f4f6fb;
  }
  .change-password-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(33,150,243,0.08);
    padding: 38px 32px 32px 32px;
    max-width: 400px;
    width: 100%;
    margin: 0 auto;
  }
  .change-password-card h2 {
    color: #1976d2;
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 18px;
    text-align: center;
  }
  .change-password-card label {
    font-weight: 500;
    color: #1976d2;
    margin-bottom: 6px;
    display: block;
  }
  .change-password-card input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #bbdefb;
    margin-bottom: 18px;
    font-size: 1rem;
    background: #f4f6fb;
    transition: border 0.2s;
  }
  .change-password-card input[type="password"]:focus {
    border-color: #1976d2;
    outline: none;
  }
  .change-password-card button {
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
  }
  .change-password-card button:hover {
    background: linear-gradient(90deg, #1565c0 0%, #1976d2 100%);
  }
  .change-password-card .error {
    color: #d32f2f;
    margin-bottom: 12px;
    text-align: center;
  }
</style>
<div class="change-password-container">
  <div class="change-password-card">
    <h2>Change Password</h2>
    <?php if(isset($message) && $message): ?>
      <div class="error"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="" method="post">
      <label for="old">Old Password</label>
      <input type="password" name="old" id="old" required>
      <label for="new">New Password</label>
      <input type="password" name="new" id="new" required>
      <label for="new_confirm">Confirm New Password</label>
      <input type="password" name="new_confirm" id="new_confirm" required>
      <button type="submit">Update Password</button>
    </form>
  </div>
</div>






</div>

</div>

 </div>




    <!-- /row --> 

    </div>

    <!-- /container --> 

  </div>

  <!-- /main-inner --> 

</div>
