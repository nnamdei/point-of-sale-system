
@extends('layouts.app')

@section('main')
<?php $tab = isset($tab) ? $tab : null ?>
<div class="mt-3">
    <div class="row justify-content-center">
        <div class="col-md-2 col-sm-4 no-padding-xs">
            <h6>{{$shop->name}}</h6>
            <p class="my-2 grey">Settings</p>
            <ul class="list-group">
                <li class="list-group-item" data-toggle="collapse" data-target="#info" aria-expanded="true" aria-controls="info">
                    <i class="fa fa-info-circle"></i> Info
                </li>
                <li class="list-group-item" data-toggle="collapse" data-target="#product" aria-expanded="true" aria-controls="product">
                    <i class="fa fa-box-open"></i> Product
                </li>
                <li class="list-group-item" data-toggle="collapse" data-target="#service" aria-expanded="true" aria-controls="service">
                    <i class="fa fa-toolbox"></i> Service
                </li>
                <li class="list-group-item text-danger" data-toggle="collapse" data-target="#delete" aria-expanded="true" aria-controls="delete">
                    <i class="fa fa-trash"></i> Delete
                </li>
            </ul>
        </div>

        <div class="col-md-4 col-sm-8 no-padding-xs">
            <div id="settings">
                <div id="info" class="collapse {{$tab === null || $tab === 'info' ? 'show' : '' }}"  data-parent="#settings">
                    
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title grey">Info</h6>
                        </div>
                        <div class="card-body">
                            @include('shop.settings.info')
                        </div>
                    </div>
                </div>
                
                <div id="product" class="collapse {{$tab === 'product' ? 'show' : '' }}" data-parent="#settings">
                    <div class="card-header">
                        <h6 class="card-title grey">Product</h6>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @include('shop.settings.product')
                        </div>
                    </div>
                </div>

                <div id="service" class="collapse {{$tab === 'service' ? 'show' : '' }}" data-parent="#settings">
                    <div class="card-header">
                        <h6 class="card-title grey">Service</h6>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @include('shop.settings.service')
                        </div>
                    </div>
                </div>

                <div id="delete" class="collapse {{$tab === 'delete' ? 'show' : '' }}" data-parent="#settings"">
                    <div class="card-header">
                        <h6 class="card-title text-danger">Delete {{$shop->name}}</h6>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @include('shop.settings.delete')
                        </div>
                    </div>
                </div>

            </div>
        </div>
            
    </div>
</div>
@endsection

