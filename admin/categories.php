<?php
	/*
	================================================
	== Template Page
	================================================
	*/
	ob_start(); // Output Buffering Start
	session_start();
	$pageTitle = 'Categories';
	if (isset($_SESSION['Username'])) {
		include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
		if ($do == 'Manage') {
		####################################
		#### Manage Page
		####################################
		$sort = 'DESC';
		$sort_array = array('ASC', 'DESC');
		if ( isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

			$sort = $_GET['sort'];

		}
		$stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
		// execute the statement
		$stmt->execute();
		// Assign the statement to variable
		$cats = $stmt->fetchAll(); ?>
		<div class="container">
			<h1 class="text-center">Manage Categories</h1>
			<div class="panel panel-default">
			  <div class="panel-heading">Manage Categories
				 <div class="options pull-right">
				  	<strong>Order BY</strong>
				  	<a class="<?php if ($sort == 'ASC') {echo 'active';} ?>" href="?sort=ASC">ASC</a> |
				  	<a class="<?php if ($sort == 'DESC') {echo 'active';} ?>" href="?sort=DESC">DESC</a>
				  	<strong>View</strong>
				  	<span data-view="full">Full</span> | <span data-view="classic">Classic</span>
			  	</div>
			  </div> 
			  <div class="panel-body">  	
			    <?php
					foreach ($cats as $cat) {	?>		
					<div class="cat clearfix">
						<div class="hidden-buttons">
							<a href="categories.php?do=Edit&catid=<?php echo $cat['ID'] ?>" class="pull-right label label-info">Edit</a>
							<a class='label label-danger pull-right confirm' href="categories.php?do=delete&catid=<?php echo $cat['ID'] ?>" >Delete</a>
						</div>
						
						<?php				
					    echo "<h3>" . $cat['Name'] . "</h3>"; 
						echo '<div class="full-view">';
						 echo "<p>" . $cat['Description'] . "</p>" ;
						 echo "<span class='label label-primary'> Order Number " . $cat['Ordering'] . "</span>";
							if ($cat['Visibility'] == 1) {
								echo "<span class='label label-default'>Hidden Item </span>";
							};						 
							if ($cat['Allow_comment'] == 1) {
								echo "<span class='label label-danger'>Comments are disabled </span>";
							};			  
							if ($cat['Allow_Ads'] == 1) {
								echo "<span class='label label-warning'>Ads are disabled </span>";
							};
						echo '</div>';
						echo '<hr>';
						
				 	} ?>
				 	</div>
				<a class='btn btn-primary' href="categories.php?do=add&catid" >Add New Category</a>
			  </div>
			</div>
		</div>
		<?php	
		} elseif ($do == 'add') {
		####################################
		#### ADD Page
		####################################
		?>	
		<h1 class="text-center">Add Category</h1>
			<div class="container">
				<form METHOD="POST" action="?do=insert" class="form-horizontal">		
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1"> Name</label>
						<div class="col-md-6">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Description</label>
						<div class="col-md-6">	
							<input type="text" name="description" class="form-control">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Ordering</label>
						<div class="col-md-6">
							<input type="number" name="ordering" class="form-control" autocomplete="off">
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Visible</label>
						<div class="col-md-6">
							<div>
								<input type='radio' id='vis-yes' name=visibility value='0' checked />
								<label for="vis-yes">Yes</label>
							</div>
							<div>
								<input type='radio' id='vis-no' name=visibility value='1' />
								<label for="vis-no">No</label>
							</div>
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Allow Commenting</label>
						<div class="col-md-6">
							<div>
								<input type='radio' id='comment-yes' name='commenting' value='0' checked />
								<label for="comment-yes">Yes</label>
							</div>
							<div>
								<input type='radio' id='comment-no' name='commenting' value='1' />
								<label for="comment-no">No</label>
							</div>
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Allow Ads</label>
						<div class="col-md-6">
							<div>
								<input type='radio' id='ads-yes' name="ads" value='0' checked />
								<label for="ads-yes">Yes</label>
							</div>
							<div>
								<input type='radio' id='ads-no' name="ads" value='1' />
								<label for="ads-no">No</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-4 col-md-offset-4">
							<input type="submit" value="ADD Category" class="form-control btn-primary">
						</div>
					</div>
				</form>
			</div>
		<?php } elseif ($do == 'insert') {
			####################################
			#### Insert Page
			####################################
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				echo "<div class='container'>";
				echo "<h1 class='text-center'>Update Member</h1>";

				// Get Variables form the form	
				$name = $_POST['name'];
				$desc = $_POST['description'];
				$order = $_POST['ordering'];
				$visible = $_POST['visibility'];
				$comment = $_POST['commenting'];
				$ads = $_POST['ads'];
				
				// check if the member already exist in database
				$check = checkItem("name", "categories", $name);
				if ($check == 1) {
					echo 'Sorry, this member exist in database';
				} else{
				// insert userinfo into DP
				$stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_comment, Allow_Ads)
										 VALUES(:zname, :zdesc, :zorder, :zvisibile, :zcommenter, :zads)");
				$stmt->execute(array(
						'zname' 	=> $name,
						'zdesc' 	=> $desc,
						'zorder' 	=> $order,
						'zvisibile' => $visible,
						'zcommenter'  => $comment,
						'zads' 		=> $ads
					));
				// echo success message ?>
				<div class='alert alert-success'>
				<?php echo  $stmt->rowCount() . 'Record updated';
				echo "</div>";

				redirectHome('', 'back'); 
				}
					
			} else {
				$theMsg = "<div class='alert alert-danger'>sorry, there is no such id</div>";
				redirectHome($theMsg, 5);
			}
			echo "</div>";	
		} elseif ($do == 'Edit') {
			####################################
			#### Edit Page
			####################################
			//if condition for security purposes
			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :  0;	
			$stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
			$stmt->execute(array($catid));
			$cat = $stmt->fetch();
			$count = $stmt->rowCount(); 

			if ($count > 0) { ?>

			<h1 class="text-center">Edit Category</h1>
			<div class="container">
				<form METHOD="POST" action="?do=update" class="form-horizontal">
				<input type="hidden" name="catid" value="<?php echo $catid ?>" />		
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1"> Name</label>
						<div class="col-md-6">
							<input type="text" name="name" class="form-control" required="required" value="<?php echo $cat['Name'] ?>">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Description</label>
						<div class="col-md-6">	
							<input type="text" name="description" class="form-control" value="<?php echo $cat['Description'] ?>">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Ordering</label>
						<div class="col-md-6">
							<input type="number" name="ordering" class="form-control" value="<?php echo $cat['Ordering'] ?>">
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Visible</label>
						<div class="col-md-6">
							<div>
								<input type='radio' id='vis-yes' name=visibility value='0' <?php if( $cat['Visibility'] == 0) {echo 'checked';} ?> />
								<label for="vis-yes">Yes</label>
							</div>
							<div>
								<input type='radio' id='vis-no' name=visibility value='1' <?php if( $cat['Visibility'] == 1) {echo 'checked';} ?> />
								<label for="vis-no">No</label>
							</div>
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Allow Commenting</label>
						<div class="col-md-6">
							<div>
								<input type='radio' id='comment-yes' name='commenting' value='0' <?php if( $cat['Allow_comment'] == 0) {echo 'checked';} ?> />
								<label for="comment-yes">Yes</label>
							</div>
							<div>
								<input type='radio' id='comment-no' name='commenting' value='1' <?php if( $cat['Allow_comment'] == 1) {echo 'checked';} ?> />
								<label for="comment-no">No</label>
							</div>
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Allow Ads</label>
						<div class="col-md-6">
							<div>
								<input type='radio' id='ads-yes' name="ads" value='0' <?php if( $cat['Allow_Ads'] == 0) {echo 'checked';} ?> />
								<label for="ads-yes">Yes</label>
							</div>
							<div>
								<input type='radio' id='ads-no' name="ads" value='1' <?php if( $cat['Allow_Ads'] == 1) {echo 'checked';} ?> />
								<label for="ads-no">No</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-4 col-md-offset-4">
							<input type="submit" value="Update Category" class="form-control btn-primary">
						</div>
					</div>
				</form>
			</div>				

		<?php	} else {
				$theMsg = "<div class='alert alert-danger'>sorry, there is no such id</div>";
				redirectHome($theMsg, 5);
		} 
	
		} elseif ($do == 'update') {
		####################################
		#### Update Page
		####################################
		echo "<div class='container'>";
		echo "<h1 class='text-center'>Update Category</h1>";

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// Get Variables form the form
			$id = $_POST['catid'];
			$name = $_POST['name'];
			$desc = $_POST['description'];
			$order = $_POST['ordering'];
			$visible = $_POST['visibility'];
			$comment = $_POST['commenting'];
			$ads = $_POST['ads'];

			// Update the DP with this Info
			$stmt = $con->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering = ?, Visibility = ?, Allow_comment = ?, Allow_Ads = ? WHERE ID = ? ");
			$stmt->execute(array($name, $desc, $order, $visible, $comment, $ads, $id)); 
			// echo success message ?>
			<div class='alert alert-success'>
			<?php echo  $stmt->rowCount() . 'Record updated';
			echo "</div>"; 
			redirectHome("" ,'back');
			
		} 

		} elseif ($do == 'delete') {
		####################################
		#### Delete Page
		####################################	
		//if condition for security purposes to check if the user exist
		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :  0;	
		
		$check = checkItem('ID', 'categories', $catid);

		if ($check > 0) {
			$stmt = $con->prepare("DELETE FROM categories WHERE ID= :zcat");
			$stmt->bindparam(":zcat", $catid);
			$stmt->execute();
			// echo success message ?>
			<div class='alert alert-success'>
			<?php echo  $stmt->rowCount() . 'Record Deleted';
			echo "</div>"; 
			redirectHome(' ', 'back'); 
		} else{
			$theMsg = "<div class='alert alert-danger'>There is no member with this ID</div>";
			redirectHome($theMsg, 'back', 5); 
		}
		};
		include $tmp . 'footer.php';
	} else {
		header('Location: index.php');
		exit();
	}
	ob_end_flush(); // Release The Output
?>