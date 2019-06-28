<html>
<title>
	Login
</title>
<link rel="shortcut icon" type="image icon" href="<?php echo base_url() ?>/assets/img/Zakat.png"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-login.css">
<body>
<?php
if ($this->session->flashdata('message')) {
	echo '<div class="alert alert-danger"><center>'. $this->session->flashdata('message') .'</center></div>';
}
?>
<div class="container">
  <div class="info">
    <center>
	<h2>SISTEM INFORMASI ZAKAT</h2>
	<br><br>
	</center>
  </div>
</div>
<div class="form">
  <div class="thumbnail"><img src="<?php echo base_url(); ?>assets/img/lock.png"/></div>
  <form class="login-form" action="<?php echo base_url(); ?>welcome/auth" method="POST">
    <input type="text" name="username" placeholder="username"/>
    <input type="password" name="password" placeholder="password"/>
    <button>login</button>
  </form>
</div>
</body>
<script src="<?php echo base_url(); ?>assets/js/jquery-2.2.4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

</html>