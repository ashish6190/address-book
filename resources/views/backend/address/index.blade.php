@extends('backend.layouts.master')
@section('content')

<div class="app-main__outer">
                    <div class="app-main__inner">
                    <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-car icon-gradient bg-mean-fruit">
                                        </i>
                                    </div>
                                    <div>Address Book
                                    </div>
                                </div>
                                <div class="page-title-actions">
                                   
                                    <div class="d-inline-block dropdown">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-business-time fa-w-20"></i>
                                            </span>
                                            Action
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="{{route('address.create')}}" class="nav-link">
                                                        <i class="nav-link-icon lnr-inbox"></i>
                                                        <span>
                                                            Add
                                                        </span>
                                                        <div class="ml-auto badge badge-pill badge-secondary"></div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>    </div>
                        </div> 
                       <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">List</h5>
                    <div class="table-responsive">
                    <!-- <h1>User Status Filter</h1> -->
                        <table id="users-table" class="display table table-striped table-bordered" style="width:100%" >
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="text-align:right;">اسم</th>
                                    <th>Category</th>
                                    <th>Fee</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="course-list">
                                <tr>
                                    <td colspan="6" style="text-align:center;">
                                        <i class="fa fa-refresh fa-spin fa fa-fw"></i>
                                        <span class="sr-only">Loading...</span>
                                    </td>
                                <tr>
                            </tbody>
                           
                        </table>
                    </div>

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
<script src="{{ asset('backend_assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('backend_assets/js/datatables.script.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script>
     
     $(function () {
   
   var table = $('#users-table').DataTable({
       processing: true,
       serverSide: true,
       "order": [],
      "aaSorting": [],
       ajax: {
         url: "#",
         data: function (d) {
               d.type = $('.searchType').val(),
               d.search = $('input[type="search"]').val()
           }
       },
       "columns": [
            {data: 'name_en', name: 'name_en'},
            {data: 'name_ar', name: 'name_ar', className: "text-right"},
            {data: 'category', name: 'category'},
            {data: 'fee', name: 'fee'},
            {data: 'duration', name: 'duration'},
            // {data: 'image', name: 'image'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}        
        ]
   });
  
   $( "#filter" ).change(function() {
       table.draw();
   });
 
 });

</script>

<script type="text/javascript">
    function changeStatus(event,id,statusId){
        var stateText = (statusId == 0) ? 'In-active' : 'Active';
        swal({
        title: 'Do you want change status to '+stateText+'?',
        type:  "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm){
    if (isConfirm){
        //    console.log("done");
            $.ajax({
                type:'POST',
                url:"#",
                data:{
                    "_token"   :  "{{ csrf_token() }}",
                        id     :  id,
                        status :  statusId,
                        },
                    success:function(data) {
                    swal('Success','course status successfully changed');
                    // timeout delay
                    $(this).delay(2000).queue(function() {
                    var table = $('#users-table').DataTable();
                    table.ajax.reload();
                        });
                }
                });
        } else {
            swal("change status operation failed!");
        }
    });
    };

    // approval course
    function changeApproval(event,id,statusId){
        var stateText = (statusId == 0) ? 'Disapproved' : 'Approved';
        swal({
        title: 'Do you want change status to '+stateText+'?',
        type:  "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm){
    if (isConfirm){
        //    console.log("done");
            $.ajax({
                type:'POST',
                url:"#",
                data:{
                    "_token"   :  "{{ csrf_token() }}",
                        id     :  id,
                        status :  statusId,
                        },
                    success:function(data) {
                    swal('Success','course approved successfully');
                    // timeout delay
                    $(this).delay(2000).queue(function() {
                    var table = $('#users-table').DataTable();
                    table.ajax.reload();
                        });
                }
                });
        } else {
            swal("change status operation failed!");
        }
    });
    };
 </script>

@endsection
