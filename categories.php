<?php include 'init.php'; ?>

<div class="container">
	<h1 class="text-center"> <?php echo $_GET['pagename']; ?> </h1>
	<div class="row">
		<?php
			$items = getItems($_GET['pageid']);
			foreach ($items as $item) {
				echo "<div class='col-md-4'>";
					echo "<div class='item text-center'>";
						echo "<div class='img-thumbnail'>";
							echo "<img class='img-responsive' src='https://placeholdit.co//i/350x200' alt=''>";
							echo "<span class='price'>" . $item['Price'] . "</span>";
							echo "<span class='country'>" . $item['Country_Made'] . "</span>";
						echo "</div>";
						echo "<div class='clearfix'> </div>";
						echo "<span>";
							echo "<strong>" . $item['Name'] . "</strong>";
						echo "</span>";
						echo "<p>";
							echo  $item['Description'];
						echo "</p>";
					echo "</div>";			
				echo "</div>";
			}
		?>
	</div>
</div>  
<?php include $tmp . 'footer.php'; ?>	