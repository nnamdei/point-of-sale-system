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
 SCANNER_ON = false;

 @if(session('scanner') == 'on')//check from laravel session if scanner should still be on
 	onScanner($('.barcode-scanner'));
 @endif
 @if(session('barcode_error'))//if there is error in scanning
 	buzzSound();
	toastr.error('{!!session('barcode_error')!!}')
 @endif
 @if(session('barcode_success'))//if there is error in scanning
	toastr.success('{!!session('barcode_success')!!}')
 @endif
   
$('.scanner-toggle').click(function(){
	var scanner = $('.barcode-scanner');
   if(scanner.attr('data-status') == 'enabled'){
		offScanner(scanner);
   }
   else{
	   onScanner(scanner);
   }
});

// Ensure the scanner is on before the form submission
$('.barcode-scanner').find('form').submit(function(e){
	// clear the input if the scanner is not on and refuse the form submission
	if(!SCANNER_ON){
		$(this).find('input[name="id"]').val(''); 
		e.preventDefault();
	}
});
// Ensure the receptor remain focused as long as the scanner is on, even if another elememt is focused
$('.scanner-receptor').blur(function(){
	if(SCANNER_ON){ 
		$(this).focus();
	}
});


function turnOnSound(sound, start = 0, repeat = false){
	sound.currentTime = start;
	sound.play().then(function(){
		if(repeat){
			sound.addEventListener('ended', function(){
			this.currentTime = 0;
			this.play();
			});
		}
	})
	
}
function turnOffSound(sound){
	sound.currentTime = 0;
	sound.pause();
}

function buzzSound(){
	buzz = new Audio('{{asset('storage/assets/buzz.mp3')}}');
	turnOnSound(buzz,7);
}
function onScanner(scanner){
	setScannerStatus('on',function(response){
		SCANNER_ON = true;
		scanner.attr('data-status','enabled');
		scanner.find('form').attr('title','scanner ready...');
		scanner.find('.scanner-receptor').focus().attr('active','true').addClass('flash');
		scanner.find('.scanner-img').attr('active','true');
		scanner.find('.scanner-aud').attr('src','');
		scanner.find('.scanner-status').html('ON');
		scanner.find('.scanner-toggle').addClass('fa-toggle-on');
		// turnOnSound(scanner_active_sound, repeat = true);
		// toastr.success('scanner turned on');
	})
}
function offScanner(scanner){
	setScannerStatus('off',function(response){
		SCANNER_ON = false;
		scanner.attr('data-status','disabled');
		scanner.find('form').attr('title','scanner not ready...');
		scanner.find('.scanner-receptor').blur().removeAttr('active').removeClass('flash');
		scanner.find('.scanner-img').removeAttr('active');
		scanner.find('.scanner-status').html('OFF')
		scanner.find('.scanner-toggle').removeClass('fa-toggle-on').addClass('fa-toggle-off');
		// turnOffSound(scanner_active_sound);
		toastr.success('Scanner turned off!');
	});
}

function setScannerStatus(power, callback){
	$.ajax({
            url: '{{route('scanner.power')}}',
            method: 'GET',
            dataType: 'json',
            data: {power: power}
        })
        .done(function (response, textStatus, jqXHR){
		   callback(response); //perform the callback
		})
		.fail(function (jqXHR, textStatus, errorThrown){
            toastr.error(`Error: ${textStatus}:${errorThrown}`);
        })
}


	function checkQty(input){
		if(input.value <= 0){
			toastr.error('invalid value, quantity cannot be '+input.value);
			input.value = '';
		}
	}
</script>
@yield('b-scripts')
