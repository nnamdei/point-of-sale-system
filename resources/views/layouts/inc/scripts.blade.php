<!-- Scripts -->
<script src="{{ asset('js/vendors/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/vendors/popper.min.js') }}"></script>
<script src="{{ asset('js/vendors/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/vendors/toastr.min.js') }}"></script>
<script src="{{ asset('js/vendors/typeahead.min.js') }}"></script>
<script src="{{ asset('js/quick-search.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>

<script>
			toastr.options = {
				"closeButton": true,
				"debug": true,
				"newestOnTop": true,
				"progressBar": true,
				"escapeHtml": false,
				"positionClass": "toast-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "0",
				"extendedTimeOut": "0",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}
	</script>
@include('layouts.inc.toastr')
@yield('scripts')
