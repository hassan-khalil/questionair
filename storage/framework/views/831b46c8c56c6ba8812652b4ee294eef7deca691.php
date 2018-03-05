<?php if(Session::has('success')): ?>
	<div class="alert alert-success alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>Success ! </strong> <?php echo e(Session::get('success')); ?>.
	</div>
<?php endif; ?>
 
<?php if(Session::has('serverError')): ?>
	<div class="alert alert-danger alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>Alert ! </strong> <?php echo e(Session::get('serverError')); ?>.
	</div>
<?php endif; ?>