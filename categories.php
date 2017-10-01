<?php include 'init.php'; ?>

<div class="container">
	<h1 class="text-center"> <?php echo $_GET['pagename']; ?> </h1>
	<ul class="list-unstyled">
		<?php
			$items = getItems($_GET['pageid']);
			foreach ($items as $item) {
				echo '<li>' . $item['Name'] . '</li>';
			}
		?>
	</ul>	
</div>  
<?php include $tmp . 'footer.php'; ?>	