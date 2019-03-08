@if (Auth::check())
	@if(Auth::user()->isManager())
		@include('layouts.components.manager-nav')
	@else
		@include('layouts.components.desk-nav')
	@endif
@endif
@include('layouts.components.modal')
