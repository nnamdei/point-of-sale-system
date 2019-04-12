<div class="dropdown">
        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="positionsDropdwon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span style="text-transaform: capitalize">{{$staff->position}}</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="positionsDropdwon">
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