@if (Auth::check())
	@if(Auth::user()->isAdminOrManager())
		@include('layouts.components.admin-nav')
	@elseif(Auth::user()->isAttendant())
		@include('layouts.components.desk-nav')
	@endif
@endif
@include('layouts.components.modal')
