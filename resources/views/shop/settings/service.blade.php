<form action="{{$_software::first()->isPremium() ? route('shop.setting.service',[$shop->id]): '#'}}" method="post">
    @csrf
    @method('PUT')

    @if(!$_software::first()->isPremium())
       @include('system.premium-only')
    @endif
    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="service-activation" name="service_activation" value="true" {{$shop->setting->serviceActivated() ? 'checked' : ''}} {{!$_software::first()->isPremium() ? 'disabled': ''}}>
            <label class="custom-control-label" for="service-activation"> Enable service</label>
        </div>
        <p  class="text-muted"><i class="fa fa-info-circle"></i> By enabling service, services can be added to <strong>{{$shop->name}}</strong> and be recorded</p>
    </div>

    <div class="form-group">
        <button type="submit" class="btn theme-btn" {{!$_software::first()->isPremium() ? 'disabled': ''}}>save</button>
    </div>

</form>