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
                        <h5 class="card-title">Edit Course</h5>
                <form id="user-form" method="POST" action="#" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                    <input type="hidden" id="course_id" name="course_id" value="">
                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Name</label>
                            <input type="text" class="form-control form-control-rounded" value="" id="name_en" name="name_en" placeholder="Enter category name">
                        </div>

                        <div class="col-md-6 form-group mb-3" style="text-align: right;">
                            <label style=" text-align: right;" for="firstName2 ">اسم</label>
                            <input type="text" class="form-control form-control-rounded" style="text-align: right;" value="" id="name_ar" name="name_ar" placeholder="أدخل اسم الفئة باللغة العربية">
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Category</label>
                            <select class="form-control form-control-rounded" id="category_id" name="category_id" placeholder="Enter category name">
                                <option value="">Select Category</option>
                               @foreach($categories as $categry)
                                <option value="{{$categry->id}}" {{$categry->id == $course->category_id  ? 'selected' : ''}}>{{$categry->name_en}}</option>
                               @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Duration (in-months)</label>
                            <input type="number" min="1" max="120" class="form-control form-control-rounded" value="{{$course->duration}}" id="duration" name="duration" placeholder="Enter category name">
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Fees (KWD)</label>
                            <input type="number" min="1" step=".001" max="100000000" class="form-control form-control-rounded" value="{{$course->fee}}" id="fee" name="fee" placeholder="Enter category name">
                        </div>

                        <div class="col-md-6 form-group mb-3" >
                            <label for="firstName2">Location</label>
                            <input type="text" class="form-control form-control-rounded" id="location" name="location" value="{{$course->location}}" placeholder="Enter category name">
                        </div>

                        <div class="col-md-12">
                            <button type="" id="btn-submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
@section('script')
<script>

    var ajax_req;

    $(document).ready(function(){     
    
        $("#user-form").validate({
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
                
                var formSubmit = fetchRequest("{{route('courses.update.store')}}");
                
                var formData = new FormData(form);
                formSubmit.setBody(formData);
                formSubmit.post().then(function (response) {

                    if (response.status === 200) {
                        $('#processing').css("display", "none")
                        // $('#user-form').trigger("reset");
                        $("#btn-submit").attr('disabled', 'disabled');
                        toastr.success("Course successfully updated", "Success", {
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            timeOut: 2e3
                        })
                        setTimeout(function () {
                            window.location.href = "{{route('courses.index')}}"; //will redirect to your blog page (an ex: blog.html)
                        }, 2000); 
   
                    }else if(response.status === 422){
                        response.json().then((errors) => { 
                            console.log(errors.errors);
                        });
                    }else{
                        toastr.error("Something went wrong", "error", {
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            timeOut: 2e3
                        })
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
