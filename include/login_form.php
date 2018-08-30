<?php
//print_r($content_lang);
?>
<div class="col-sm-8 text-center hidden-xs" style="margin-top:20px">
			<!--<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="#section1">Dashboard</a></li>
				<li><a href="#section2">Age</a></li>
				<li><a href="#section3">Gender</a></li>
				<li><a href="#section3">Geo</a></li>
			</ul><br>-->
			<img src="images/ltfhc_logo.png" width=800>
		</div><br>
		<div class="col-sm-4 text-left">
			<div class="well">
				<h2><?php echo $content_lang['0']['content']; ?></h2>
				<!--<div class="alert alert-danger"></div>-->
				<form role="form" id="form_login">
					<div class="form-group">
						<label for="login_id"><?php echo $content_lang['1']['content']; ?> :</label>
						<input type="text" class="form-control" name="login_id" id="login_id" placeholder="<?php echo $content_lang['3']['content']." ".$content_lang['0']['content']." ".$content_lang['1']['content']; ?>">
						<input type="hidden" class="form-control" name="language" value="<?php if (isset($_REQUEST['language'])){ echo $_REQUEST['language']; } else { echo "en"; } ?>">
					</div>
					<div class="form-group">
						<label for="pwd"><?php echo $content_lang['2']['content']; ?> :</label>
						<input type="password" class="form-control" name="password" id="pwd" placeholder="<?php echo $content_lang['3']['content']." ".$content_lang['2']['content']; ?>">
					</div>
					
					<a style="margin:5px; float:right;" href="index.php?page=forgot_password&language=<?php echo $language; ?>" ><?php echo $content_lang['73']['content']; ?></a>
				
					<br>
					<button class="btn btn-danger" id="btn-login"><?php echo $content_lang['5']['content']; ?></button>
					<div class="loader"></div>
				</form>
			</div>
		</div>