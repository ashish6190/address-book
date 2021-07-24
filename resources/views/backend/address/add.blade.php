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
                                <h5 class="card-title">Add Address</h5>
                <form id="address-form" method="POST" action="#" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">First Name</label>
                            <input type="text" class="form-control form-control-rounded" id="first_name" name="first_name" placeholder="Enter first name">
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">First Name</label>
                            <input type="text" class="form-control form-control-rounded" id="last_name" name="last_name" placeholder="Enter last name">
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                        <label for="firstName2">Profile Pic</label>
                            <input type="file" class="form-control form-control-rounded" id="profile_pic" name="profile_pic" placeholder="Upload your profile pic">
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Email</label>
                            <input type="email" class="form-control form-control-rounded" id="email" name="email" placeholder="Enter your email">
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Phone</label>
                            <input type="number"  class="form-control form-control-rounded" id="phone" name="phone" placeholder="Enter your phone number">
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Street</label>
                            <input type="text" class="form-control form-control-rounded" id="street" name="street" placeholder="Enter street">
                        </div>
                        
                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Zip-Code</label>
                            <input type="text" class="form-control form-control-rounded" id="zipcode" name="zipcode" placeholder="Enter zip-code">
                        </div>
                        <div class="col-md-6 form-group mb-3" >
                        <label for="firstName2">City</label>
                            <select class="form-control form-control-rounded" id="city" name="city" placeholder="Enter your city name">
                                <option value="">Select City</option>
                               
                                <option value="1">Varansai</option>
                            </select>
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
                
            
                name_en: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                name_ar: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                fee: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                duration: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                location: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                },
                category_id: {
                    required              : true,
                    normalizer: function( value ) {
                        return $.trim( value );
                    },
                }
                
            },
            messages: {
                name_en   :  {
                    required              : "Please enter category name",
                },
                name_ar   :  {
                    required              : "الرجاء إدخال اسم الفئة",
                },
                fee   :  {
                    required              : "Please enter course fee",
                },
                duration   :  {
                    required              : "Please enter course duration",
                },
                location   :  {
                    required              : "Please enter course location",
                },
                category_id   :  {
                    required              : "Please select course category",
                },
                
            },
            submitHandler: function(form,event) {
                $('#processing').css("display", "block");
                $("#btn-submit").attr('disabled', 'disabled');
                
                var formSubmit = fetchRequest("{{route('address.store')}}");
                
                var formData = new FormData(form);
                formSubmit.setBody(formData);
                formSubmit.post().then(function (response) {

                    if (response.status === 200) {
                        $('#processing').css("display", "none")
                        $('#user-form').trigger("reset");
                        $("#btn-submit").removeAttr('disabled', 'disabled');
                        toastr.success("Course successfully created", "Success", {
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            timeOut: 2e3
                        })
                        setTimeout(function () {
                            window.location.href = "{{route('address.index')}}"; //will redirect to your blog page (an ex: blog.html)
                        }, 2000); 
   
                    }else if(response.status === 422){
                        response.json().then((errors) => {
                            console.log(errors.errors);
                        });
                    }
                });
            }
        });

    });
</script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/parsley.js') }}"></script>
@endsection
