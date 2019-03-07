@if (Auth::check())
	@if(Auth::user()->isManager())
		@include('layouts.inc.manager-nav')
	@else
		@include('layouts.inc.desk-nav')
	@endif
@endif
@include('layouts.inc.modal')
