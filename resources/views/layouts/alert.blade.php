@if(Session::has('success'))
	<div class="alert alert-success alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>Success ! </strong> {{Session::get('success') }}.
	</div>
@endif
 
@if(Session::has('serverError'))
	<div class="alert alert-danger alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>Alert ! </strong> {{Session::get('serverError') }}.
	</div>
@endif