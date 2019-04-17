<div class="py-2 text-center text-muted">
        <h2><i class="fa fa-exclamation-triangle"></i></h2>
        <p>Service is not enabled for {{Auth::user()->shop->name}}, go to <a href="{{route('shop.setting',[Auth::user()->shop->id,'tab' => 'service'])}}">settings</a> to enable service</p>
    </div>
