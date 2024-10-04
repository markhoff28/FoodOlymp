@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">
  <div class="container-fluid">
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0 font-size-18">Edit Permission</h4>
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('all.permission') }}">All Permission</a></li>
              <li class="breadcrumb-item active">Edit Permission </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->
    <div class="row">
      <div class="col-xl-9 col-lg-8">
        <div class="card">
          <div class="card-body p-4">
            <form id="myForm" action="{{ route('update.permission') }}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="id" value="{{ $permission->id  }}">
              <div class="row">
                <div class="col-lg-6">
                  <div>
                    <div class="form-group mb-3">
                      <label for="example-text-input" class="form-label">Permission Name</label>
                      <input class="form-control" type="text" name="name" id="example-text-input" value="{{ $permission->name }}">
                    </div>
                    <div class="form-group mb-3">
                      <label for="example-text-input" class="form-label">Permission Group </label>
                      <select name="group_name" class="form-select">
                        <option selected disabled>Select Permission</option>
                        <option value="Category" {{ $permission->group_name == 'Category' ? 'selected' : '' }}>Category</option>
                        <option value="City" {{ $permission->group_name == 'City' ? 'selected' : '' }}>City</option>
                        <option value="Product" {{ $permission->group_name == 'Product' ? 'selected' : '' }}>Product</option>
                        <option value="Restaurant" {{ $permission->group_name == 'Restaurant' ? 'selected' : '' }}>Restaurant</option>
                        <option value="Banner" {{ $permission->group_name == 'Banner' ? 'selected' : '' }}>Banner</option>
                        <option value="Order" {{ $permission->group_name == 'Order' ? 'selected' : '' }}>Order</option>
                        <option value="Reports" {{ $permission->group_name == 'Reports' ? 'selected' : '' }}>Reports</option>
                        <option value="Review" {{ $permission->group_name == 'Review' ? 'selected' : '' }}>Review</option>
                        <option value="Role and Permission" {{ $permission->group_name == 'Role and Permission' ? 'selected' : '' }}>Role and Permission</option>
                        <option value="Content Management User" {{ $permission->group_name == 'Content Management User' ? 'selected' : '' }}>Content Management User</option>
                        <option value="Business Intelligence User"{{ $permission->group_name == 'Business Intelligence User' ? 'selected' : '' }}>Business Intelligence User</option>
                        <option value="All User"{{ $permission->group_name == 'All User' ? 'selected' : '' }}>All User</option>
                      </select>
                    </div>
                    <div class="mt-4">
                      <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                    </div>

                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>

        <!-- end tab content -->
      </div>
      <!-- end col -->

      <!-- end col -->
    </div>
    <!-- end row -->

  </div> <!-- container-fluid -->
</div>


@endsection