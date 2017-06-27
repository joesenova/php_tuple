<?php
ini_set('memory_limit',-1);
ini_set('max_execution_time', 0);


/**
*
* @author 	Johan Kasselman <johankasselman@live.com>
* @since 	27/05/2017
*
*/

//-----------------------------------------------------------------------------------------------
?>
<div class="container">
	<!-- Heading -->
	<h2>Upload File</h2>
	<hr />
	<form action="generate_tuple.php" method="post" class="form-group" enctype="multipart/form-data">
		<div class="form-group">
			<label for="file">File:</label>
			<input type="file" name="file"  />
		</div>
		<button type="submit" class="btn btn-primary">Generate Tuple 1</button>
	</form>
</div>