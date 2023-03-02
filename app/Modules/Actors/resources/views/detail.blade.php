<div id="popover-content">
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body border p-0">
                    <p>
                        <a class="btn btn-primary w-100 h-100 d-flex align-items-center">
                            <span class="d-flex justify-content-between">Actors Info</span>
                        </a>
                    </p>
                </div>
                <div class="card-body border p-0">
                    <div class="collapse show p-2 pt-0">
                        <div class="row">
                            <div class="col-lg-6">
                                @isset($actor->profileImage[0]->image)
                                <div class="p-0 me-0">
                                    <img class="img-responsive actor-details-img" src="{{ $actor->profileImage[0]?->image }}" alt=" "/>
                                </div>
                                @endisset
                            </div>
                            <div class="col-lg-6 mb-lg-0 mb-3">
                                <h6 class="h4 mb-2 fw-bold"><b>{{$actor->user->first_name." ".$actor->user->last_name}}</b></h6>
                                <p class="mb-1"><span class="fw-bold"><b>Ethnicity:</b></span><span
                                        class="c-green">{{$actor->ethnicity}}</span>
                                      
                                </p>
                                <p class="mb-1">
                                    <span class="fw-bold"><b>Gender:</b></span>
                                    <span class="c-green">{{$actor->gender}}</span>
                                </p>
                                <p class="mb-1">
                                    <span class="fw-bold"><b>Date of birth:</b></span>
                                    <span class="c-green">{{$actor->date_of_birth}}</span>
                                </p>
                                <p class="mb-1">
                                    <span class="fw-bold"><b>Complexions:</b></span>
                                    <span class="c-green">{{$actor->complexions}}</span>
                                </p>
                                <p class="mb-1">
                                    <span class="fw-bold"><b>Current Location:</b></span>
                                    <span class="c-green">{{$actor->current_location}}</span>
                                </p>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
          
        </div>
    </div>
</div>
