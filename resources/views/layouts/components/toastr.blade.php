<script>
    @if(session('success'))
            toastr.success("{!!session('success')!!}");
    @endif
    @if(session('info'))
            toastr.info("{!!session('info')!!}");
    @endif

    @if(session('warning'))
            toastr.warning("{!!session('warning')!!}");
    @endif

    @if(session('error'))
            toastr.error("{!!session('error')!!}");
    @endif

    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
                toastr.error('{{$error}}');
        @endforeach      
    @endif

</script>