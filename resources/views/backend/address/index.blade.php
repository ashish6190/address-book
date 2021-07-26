@extends('backend.layouts.master')
@section('content')

<div class="app-main__outer">
                    <div class="app-main__inner">
                        @if (\Session::has('success'))
                        <div class="alert alert-success mb-2">
                        <p>{{ \Session::get('success') }}</p>
                            </div>
                        @endif
                        @if (\Session::has('failure'))
                            <div class="alert alert-danger mb-2">
                            <p>{{ \Session::get('failure') }}</p>
                            </div>
                        @endif
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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Street</th>
                                    <th>Zip-code</th>
                                    <th>City</th>
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
<script>
     
     $(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        "order": [],
         "aaSorting": [],
        ajax: '{!! route('address.list') !!}',
        "columns": [
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'street', name: 'street'},
            {data: 'zipcode', name: 'zipcode'},
            {data: 'city', name: 'city'},
            {data: 'action', name: 'action', orderable: false, searchable: false}      
        ],
        "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
        "iDisplayLength": 50,
    });
});

</script>
@endsection
