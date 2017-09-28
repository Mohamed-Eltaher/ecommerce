<?php
	/*
	================================================
	== Items Page
	================================================
	*/
	ob_start(); // Output Buffering Start
	session_start();
	$pageTitle = 'Items';
	if (isset($_SESSION['Username'])) {
		include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
		if ($do == 'Manage') {
		####################################
		#### Manage Page
		####################################
		$stmt = $con->prepare(" SELECT items.*, 
								categories.Name AS category_name, 
								users.Username 
							FROM 
								items
							INNER JOIN 
								categories 
							ON 
								categories.ID = items.Cat_ID 
							INNER JOIN 
								users 
							ON 
								users.UserID = items.Member_ID ");
							
		// execute the statement
		$stmt->execute();
		// Assign the statement to variable
		$items = $stmt->fetchAll();
?>
		<h1 class="text-center">Manage Items</h1>
		<div class="container">
			<div class="table-responsive">
				<table class="table table-bordered text-center">
					<tr class="info">
						<td>#ID</td>
						<td>name</td>
						<td>Description</td>
						<td>Price</td>
						<td>Adding date</td>
						<td>Category</td>
						<td>UserName</td>
						<td>Control</td>
					</tr>
					<?php 
					foreach ($items as $item) {
						echo '<tr>';
							echo '<td>' . $item['Item_ID'] . '</td>';
							echo '<td>' . $item['Name'] . '</td>';
							echo '<td>' . $item['Description'] . '</td>';
							echo '<td>' . $item['Price'] . '</td>';
							echo '<td>' . $item['Add_Date'] . '</td>';
							echo '<td>' . $item['category_name'] . '</td>';
							echo '<td>' . $item['Username'] . '</td>';
							echo "<td> <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] ."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
							<a href='items.php?do=delete&itemid=" . $item['Item_ID'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
							if ($item['Approve'] == 0 ) {
								 	echo "<a href='items.php?do=approve&itemid=" . $item['Item_ID'] ."' class='btn btn-info'><i class='fa fa-check'></i> Approve</a>";
								 }	 
							 echo "</td>";	
						echo '</tr>';
					}
					?>
				</table>
			</div>
			<a href='items.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i> new Item</a>
		</div>
		<?php } elseif ($do == 'add') {
		####################################
		#### ADD Page
		####################################
		?>	
		<h1 class="text-center">Add Item</h1>
			<div class="container">
				<form METHOD="POST" action="?do=insert" class="form-horizontal">		
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1"> Item Name</label>
						<div class="col-md-6">
							<input type="text" name="item-name" class="form-control" autocomplete="off" required="required">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Description</label>
						<div class="col-md-6">	
							<input type="text" name="description" class="form-control">
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Price</label>
						<div class="col-md-6">	
							<input type="text" name="price" class="form-control">
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Counrty</label>
						<div class="col-md-6">	
							<input type="text" name="country" class="form-control">
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Status</label>
						<div class="col-md-6">	
							<select class="form-control" name='rating'>
								<option value=0>A</option>
								<option value=1>B</option>
								<option value=2>C</option>
								<option value=3>D</option>
							</select>
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Users</label>
						<div class="col-md-6">	
							<select class="form-control" name='member'>
								<option value='0'>...</option>
								<?php 
									$stmt2 = $con->prepare("SELECT * FROM users");	
									$stmt2->execute();
									$users = $stmt2->fetchAll();
									foreach ($users as $user) {
										echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
									}
								 ?>
							</select>
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Categories</label>
						<div class="col-md-6">	
							<select class="form-control" name='category'>
								<option value='0'>...</option>
								<?php 
									$stmt = $con->prepare("SELECT * FROM categories");	
									$stmt->execute();
									$cats = $stmt->fetchAll();
									foreach ($cats as $cat) {
										echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
									}
								 ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-4 col-md-offset-4">
							<input type="submit" value="ADD Item" class="form-control btn-primary">
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
				echo "<h1 class='text-center'>Update Item</h1>";

				// Get Variables form the form	
				$name = $_POST['item-name'];
				$desc = $_POST['description'];
				$price = $_POST['price'];
				$country = $_POST['country'];
				$status = $_POST['rating'];
				$users = $_POST['member'];
				$categories = $_POST['category'];
							
				// insert userinfo into DP
				$stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Add_Date, 	Member_ID, Cat_ID)
										 VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zmember, :zcatid)");
				$stmt->execute(array(
						'zname' 	=> $name,
						'zdesc' 	=> $desc,
						'zprice' 	=> $price,
						'zcountry'  => $country,
						'zstatus'   => $status,
						'zmember'   => $users,
						'zcatid'    => $categories,
					));
				// echo success message ?>
				<div class='alert alert-success'>
				<?php echo  $stmt->rowCount() . 'Record updated';
				echo "</div>";

				redirectHome('', 'back'); 
				
					
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
		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;	
		$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
		$stmt->execute(array($itemid));
		$item = $stmt->fetch();
		$count = $stmt->rowCount(); 

		if ($count > 0) { ?>
			<h1 class="text-center">Edit Item</h1>
			<div class="container">
				<form METHOD="POST" action="?do=update" class="form-horizontal">
				<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1"> Item Name</label>
						<div class="col-md-6">
							<input type="text" name="item-name" class="form-control" autocomplete="off" required="required" value="<?php echo $item['Name'] ?>">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Description</label>
						<div class="col-md-6">	
							<input type="text" name="description" class="form-control" value="<?php echo $item['Description'] ?>">
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Price</label>
						<div class="col-md-6">	
							<input type="text" name="price" class="form-control" value="<?php echo $item['Price'] ?>">
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Counrty</label>
						<div class="col-md-6">	
							<input type="text" name="country" class="form-control" value="<?php echo $item['Country_Made'] ?>">
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Status</label>
						<div class="col-md-6">	
							<select class="form-control" name='rating'>
								<option value=0 <?php if ( $item['Status'] == 0) {echo 'selected';} ?> >A</option>
								<option value=1 <?php if ( $item['Status'] == 1) {echo 'selected';} ?> >B</option>
								<option value=2 <?php if ( $item['Status'] == 2) {echo 'selected';} ?>>C</option>
								<option value=3 <?php if ( $item['Status'] == 3) {echo 'selected';} ?>>D</option>
							</select>
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Users</label>
						<div class="col-md-6">	
							<select class="form-control" name='member'>
								
								<?php 
									$stmt2 = $con->prepare("SELECT * FROM users");	
									$stmt2->execute();
									$users = $stmt2->fetchAll();
									foreach ($users as $user) {
										echo "<option value='" . $user['UserID'] . "'";
										if ( $item['Member_ID'] == $user['UserID']) { echo 'selected';}
										echo ">" . $user['Username'] . "</option>";
									}
								 ?>
							</select>
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="control-label col-md-2 col-md-offset-1">Categories</label>
						<div class="col-md-6">	
							<select class="form-control" name='category'>
								
								<?php 
									$stmt = $con->prepare("SELECT * FROM categories");	
									$stmt->execute();
									$cats = $stmt->fetchAll();
									foreach ($cats as $cat) {
										echo "<option value='" . $cat['ID'] . "'";
										if ( $item['Cat_ID'] == $cat['ID']) { echo 'selected';}
										echo ">" . $cat['Name'] . "</option>";
									}
								 ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-4 col-md-offset-4">
							<input type="submit" value="Update Item" class="form-control btn-primary">
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
		echo "<h1 class='text-center'>Update Item</h1>";

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// Get Variables form the form
			$id = $_POST['itemid'];
			$name = $_POST['item-name'];
			$desc = $_POST['description'];
			$price = $_POST['price'];
			$country = $_POST['country'];
			$status = $_POST['rating'];
			$users = $_POST['member'];
			$categories = $_POST['category'];

			// Update the DP with this Info
			$stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Member_ID = ?, Cat_ID = ? WHERE Item_ID = ? ");

			$stmt->execute(array($name, $desc, $price, $country, $status, $users, $categories, $id)); 
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
		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;	
		
		$check = checkItem('Item_ID', 'items', $itemid);

		if ($check > 0) {
			$stmt = $con->prepare("DELETE FROM items WHERE Item_ID= :zitem");
			$stmt->bindparam(":zitem", $itemid);
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
		} elseif($do == 'approve') {
		####################################
		#### Approve Page
		####################################	
		//if condition for security purposes to check if the user exist
		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;	
		$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
		$stmt->execute(array($itemid));
		$count = $stmt->rowCount();  

		if ($count > 0) {
			$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ? ");
			$stmt->execute(array($itemid));
			// echo success message ?>
			<div class='alert alert-success'>
			<?php echo  $stmt->rowCount() . 'Record Approved';
			echo "</div>"; 
			redirectHome("", 'back'); 
		} else{
			$theMsg = "<div class='alert alert-danger'>There is no member with this ID</div>";
			redirectHome($theMsg, 'back', 5); 
		}
	}
		include $tmp . 'footer.php';
	} else {
		header('Location: index.php');
		exit();
	}
	ob_end_flush(); // Release The Output
?>