@extends($activeTemplate.'layouts.master')
@section('content')
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active text-dark" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">@lang('Profile')</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link text-dark" id="edit-profile-tab" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button" role="tab" aria-controls="edit-profile" aria-selected="false">edit-profile</button>
    </li>

  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card overflow-hidden shadow mt-5 border-0 rounded">
            <div class="card-body p-0 ">
                <div class="p-3 bg--white">
                    <div class="dashboard-user">
                    <div class="user-thumb">
                        <img src="{{ getImage('assets/images/user/profile/'. auth()->user()->image, '350x300')}}" alt="dashboard">
                    </div>
                </div>


                    <ul class="list-group mt-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>@lang('Name')</span> {{auth()->user()->fullname}}
                        </li>
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span>@lang('Username')</span> {{auth()->user()->username}}
                        </li>
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span>@lang('Email')</span> {{auth()->user()->email}}
                        </li>
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span>@lang('Mobile Number')</span> {{auth()->user()->mobile}}
                        </li>
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span>@lang('Address')</span> {{auth()->user()->address->address}}
                        </li>
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span>@lang('City')</span> {{auth()->user()->address->city}}
                        </li>
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span>@lang('State')</span> {{auth()->user()->address->state}}
                        </li>
                        <li class="list-group-item rounded-0 d-flex justify-content-between">
                            <span>@lang('Zip/Postal')</span> {{auth()->user()->address->zip}}
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>@lang('Joined at')</span> {{date('d M, Y h:i A',strtotime(auth()->user()->created_at))}}
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
        <div class="card overflow-hidden shadow mt-5 border-0 rounded">
            <div class="card-body">
                <h5 class="card-title mb-50 border-bottom pb-2">{{auth()->user()->fullname}} @lang('Information')</h5>

                <form class="register prevent-double-click" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="InputFirstname" class="col-form-label">@lang('First Name'):</label>
                            <input type="text" class="form-control form--control" id="InputFirstname" name="firstname" placeholder="@lang('First Name')" value="{{$user->firstname}}" minlength="3">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="lastname" class="col-form-label">@lang('Last Name'):</label>
                            <input type="text" class="form-control form--control" id="lastname" name="lastname" placeholder="@lang('Last Name')" value="{{$user->lastname}}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="email" class="col-form-label">@lang('E-mail Address'):</label>
                            <input class="form-control form--control" id="email" placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="phone" class="col-form-label">@lang('Mobile Number')</label>
                            <input class="form-control form--control" id="phone" value="{{$user->mobile}}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="address" class="col-form-label">@lang('Address'):</label>
                            <input type="text" class="form-control form--control" id="address" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" required="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="state" class="col-form-label">@lang('State'):</label>
                            <input type="text" class="form-control form--control" id="state" name="state" placeholder="@lang('state')" value="{{@$user->address->state}}" required="">
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="zip" class="col-form-label">@lang('Zip Code'):</label>
                            <input type="text" class="form-control form--control" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" required="">
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="city" class="col-form-label">@lang('City'):</label>
                            <input type="text" class="form-control form--control" id="city" name="city" placeholder="@lang('City')" value="{{@$user->address->city}}" required="">
                        </div>

                        <div class="form-group col-sm-4">
                            <label class="col-form-label">@lang('Country'):</label>
                            <input class="form-control form--control" value="{{@$user->address->country}}" disabled>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size']) }}" alt="@lang('Image')">
                            <div class="form-group">
                                <label>@lang('Image')</label>
                                <input class="form-control" type="file" name="image">
                                <code>@lang('Image size') {{imagePath()['profile']['user']['size']}}</code>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row pt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn--base w-100">@lang('Update Profile')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>


@endsection

