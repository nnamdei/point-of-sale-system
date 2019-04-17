@if(Auth::user()->isAdmin())
    <div class="dropdown">
        <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="positionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span style="text-transform: capitalize">{{$staff->position}}</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="positionsDropdown">
                <div class="p-2"><small>change {{$staff->firstname}} position in {{$staff->shop->name}}</small></div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item">
                    <div class="d-flex">
                        <div>
                            @include('staff.widgets.operations.make-regular-staff')
                        </div>
                        @if($staff->isRegularStaff())
                            <div class="ml-auto">
                                <i class="fa fa-check"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item">
                    <div class="d-flex">
                        <div>
                            @include('staff.widgets.operations.make-attendant')
                        </div>
                        @if($staff->isAttendant())
                            <div class="ml-auto">
                                <i class="fa fa-check"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item">
                    <div class="d-flex">
                        <div>
                            @include('staff.widgets.operations.make-manager')
                        </div>
                        @if($staff->isManager())
                            <div class="ml-auto">
                                <i class="fa fa-check"></i>
                            </div>
                        @endif
                    </div>
                </div>
        </div>
    </div>
@else
    <button class="btn btn-link btn-sm " type="button">
        <span style="text-transform: capitalize">{{$staff->position}}</span>
    </button>
@endif