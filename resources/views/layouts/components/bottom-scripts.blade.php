<script src="{{ asset('js/vendors/popper.min.js') }}"></script>
<script src="{{ asset('js/vendors/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/vendors/toastr.min.js') }}"></script>
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
@include('layouts.components.toastr')
<script src="{{ asset('js/confirm-delete.js') }}"></script>
<script src="{{ asset('js/image-preview.js') }}"></script>
<!-- Extra scripts -->
<script>
	function checkQty(input){
		if(input.value <= 0){
			toastr.error('invalid value, quantity cannot be '+input.value);
			input.value = '';
		}
	}
</script>
@yield('b-scripts')
