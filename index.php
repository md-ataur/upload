<?php 
include 'lib/config.php';
include 'lib/Database.php';
include 'inc/header.php';

$db = new Database();
?>
	<div class="myform">
		<!-- image upload mechanism -->
		<?php
			if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
				$permited  = array('jpg', 'jpeg', 'png', 'gif' );
				$file_name = $_FILES['image']['name'];
				$file_size = $_FILES['image']['size'];
				$file_temp = $_FILES['image']['tmp_name'];
				
				$explode = explode('.', $file_name);
				$file_ext = strtolower(end($explode));
				$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
				$upload_img = "uploads/".$unique_image;

				if (empty($file_name)) {
					echo "<span class='error'> Please select image !</span>";
				}elseif ($file_size > 1048576) {
					echo "<span class='error'> Image size should be less than 1 KB !</span>";
				}elseif (in_array($file_ext, $permited) === false) {
					echo "<span class='error'> You can upload only:-".implode(', ', $permited). "</span>";
				}else{
					move_uploaded_file($file_temp, $upload_img);
					$query  = "INSERT INTO tbl_upload(image) VALUES ('$upload_img')";
					$result = $db->insert($query);
					if($result){
						echo "<span class='success'>Image Successfully uploaded</span>";
					}else{
						echo "<span class='error'>Image Not uploaded</span>";
					}
				}
				
			}
		?>
		<form action="" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Select Image</td>
					<td><input type="file" name="image"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="Upload"/></td>
				</tr>
			</table>
		</form>

		
		</br>

		<!-- image delete -->
		<?php
			if (isset( $_GET['id'])) {
				$id = $_GET['id'];

				$getquery = "SELECT * FROM tbl_upload WHERE id = '$id'";
				$getimg = $db->select($getquery);
				if ($getimg) {
					while ($img = $getimg->fetch_assoc()) {
					 	$delimg = $img['image'];
					 	unlink($delimg);
					}
				}
				 
				$query  = "DELETE FROM tbl_upload WHERE id ='$id'";
				$delete = $db->delete($query);
				if($delete){
					echo "<span class='success'>Successfully Delete</span>";
				}
			}
			
		?>
		</br>

		<!-- Image show in table -->
		<table border="1" width="300px" style="text-align: center">
			<tr>
				<th>No</th>
				<th>Image</th>
				<th>Action</th>
			</tr>
			<?php 
				$query  = "SELECT * FROM tbl_upload";
				$getImg = $db->select($query);
				if($getImg){
					$i = 0;
					while ($result = $getImg->fetch_assoc()) {		
						$i++;
			?>
			<tr>
				<td><?php echo $i;?></td>
				<td><img src="<?php echo $result['image'];?>" width="80px" height="50px"></td>
				<td><a href="?id=<?php echo $result['id']?>">Delete</a></td>
			</tr>
			<?php } }?>
		</table>

	</div>
<?php //include 'inc/footer.php';?>