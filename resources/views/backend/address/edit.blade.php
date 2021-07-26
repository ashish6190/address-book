@extends('backend.layouts.master')
@section('content')
<style>
.error {
    color: red !important;
}
</style>
<style>
.error {
    color: red !important;
}
</style>
                <div class="app-main__outer">
                    <div class="app-main__inner">
                       <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Edit Address Book</h5>
                <form id="address-form" method="POST" action="#" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="contact_id" value="{{$contact->id}}">
                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">First Name</label>
                            <input type="text" class="form-control form-control-rounded" value="{{$contact->first_name}}" id="first_name" name="first_name" placeholder="Enter first name">
                            @error('first_name')
                            <label id="label-error" class="error" for="first_name">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Last Name</label>
                            <input type="text" class="form-control form-control-rounded" value="{{$contact->last_name}}" id="last_name" name="last_name" placeholder="Enter last name">
                            @error('first_name')
                            <label id="label-error" class="error" for="first_name">{{ $last_name }}</label>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                        <label for="firstName2">Profile Pic (150 x 150)</label>
                            <input type="file" class="form-control form-control-rounded"  id="profile_pic" name="profile_pic" placeholder="Upload your profile pic">
                            @error('profile_pic')
                            <label id="label-error" class="error" for="first_name">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Email</label>
                            <input type="email" class="form-control form-control-rounded" value="{{$contact->email}}" id="email" name="email" placeholder="Enter your email">
                            @error('first_name')
                            <label id="label-error" class="error" for="first_name">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Phone</label>
                            <input type="number"  class="form-control form-control-rounded" value="{{$contact->phone}}" id="phone" name="phone" placeholder="Enter your phone number">
                            @error('phone')
                            <label id="label-error" class="error" for="first_name">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Street</label>
                            <input type="text" class="form-control form-control-rounded" value="{{$contact->street}}" id="street" name="street" placeholder="Enter street">
                            @error('street')
                            <label id="label-error" class="error" for="first_name">{{ $message }}</label>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Zip-Code</label>
                            <input type="number" class="form-control form-control-rounded" value="{{$contact->zipcode}}" id="zipcode" name="zipcode" placeholder="Enter zip-code">
                            @error('zipcode')
                            <label id="label-error" class="error" for="first_name">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group mb-3" >
                        <label for="firstName2">City</label>
                            <select class="form-control form-control-rounded"  id="city" name="city" placeholder="Enter your city name">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{$city->id}}" @if($contact->city == $city->id) selected @endif>{{$city->name}}</option>
                                @endforeach
                            </select>
                            @error('city')
                            <label id="label-error" class="error" for="first_name">{{ $message }}</label>
                            @enderror
                            </div>
                        <div class="col-md-12">
                            <button type="" id="btn-submit" class="btn btn-primary ">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 1
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 2
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="app-footer-right">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 3
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                <div class="badge badge-success mr-1 ml-0">
                                                    <small>NEW</small>
                                                </div>
                                                Footer Link 4
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
</div>
@endsection
@section('script')
<script>

    var ajax_req;

    $(document).ready(function(){     
        
        $("#address-form").validate({
            rules: {
                
            
                first_name: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                last_name: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                
                email: {
                required: true,
                email: true,
                remote: {
                            url: "{{route('user.email')}}",
                            type: "post",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': "{{$contact->id}}"
                                }
                        }
                },
                phone: {
                    required              : true,
                    maxlength             : 10,
                    minlength             : 10,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                street: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                zipcode: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                city: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                
            },
            messages: {
                first_name   :  {
                    required              : "Please enter first name",
                },
               
                last_name   :  {
                    required              : "Please enter last name",
                },
                
                email   :  {
                    required              : "Please enter email",
                    email                  : "Please enter a valid email address.",
				    remote                : "Email already in use!"
                },
                phone   :  {
                    required              : "Please enter phone",
                    maxlength              : "Please enter your 10 digit numbers.",
                },
                street   :  {
                    required              : "Please enter street",
                },
                zipcode   :  {
                    required              : "Please enter zipcode",
                },
                city   :  {
                    required              : "Please select city",
                },
                
            },
        });

    });

    $(document).ready(function() {
            $('input[type="file"]').change(function() {
                $('#label-error').hide();
            });
        });
</script>
@endsection
