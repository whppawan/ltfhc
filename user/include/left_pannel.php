<ul>
	<?php if($login_sub_type=="wish_admin"){ ?>
	<li class="<?php echo $clinic; ?>">&nbsp;<a href="?page=clinic&action=add">Clinic</a></li>
	<li class="<?php echo $user; ?>">&nbsp;<a href="?page=user&action=add">User</a></li>
	<?php }else if($login_sub_type=="admin"){ ?>
	<li class="<?php echo $clinic; ?>">&nbsp;<a href="?page=clinic&action=add">Clinic</a></li>
	<li class="<?php echo $user; ?>">&nbsp;<a href="?page=user&action=add">User</a></li>
	<li class="<?php echo $category; ?>">&nbsp;<a href="?page=category&action=add">Category</a></li>
	<li class="<?php echo $question; ?>">&nbsp;<a href="?page=question&action=add">Question</a></li>
	<li class="<?php echo $indicator; ?>">&nbsp;<a href="?page=indicator&action=add">Indicator</a></li>
	<li class="<?php echo $district; ?>">&nbsp;<a href="?page=district&action=add">District</a></li>
	<li class="<?php echo $location; ?>">&nbsp;<a href="?page=location&action=add">Location</a></li>
    <?php } ?>
	<li class="">&nbsp;</li>
</ul>
