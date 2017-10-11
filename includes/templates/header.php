<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="UTF-8">
	<title><?php echo page_title(); ?></title>
	<link rel="stylesheet" href="<?php echo $css;?>font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $frontcss;?>frontend.css">
</head>
<body>
	<div class="upper-bar">
		<div class="container">
			<?php
				if (isset($_SESSION['member'])){
					echo ' Hello' . ' ' .  $sessionUser . ' ' . 
					 "<a href='profile.php'>My Profile</a> - <a href='logout.php'>logout</a>"  . '</br>';
					$userstatus = userStatus($sessionUser);
						if ($userstatus == 1) {
						echo "Your Membership need to be activated";
						}
					} else { 
			?>	
			<a class='pull-right' href="login.php">Login | Logout</a>
			<?php } ?>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
  		<div class="container">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="index.php">HomePage</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <?php
	        	$categories = getCats();
				foreach ($categories as $category) {
					echo "<li> <a href='categories.php?pageid=" . $category['ID'] ."&pagename=" . $category['Name'] ."'>" .  $category['Name'] . "</a> </li>";
				}
	        ?>
	      </ul> 
	    </div><!-- /.navbar-collapse -->
  		</div><!-- /.container -->
	</nav>
		
	