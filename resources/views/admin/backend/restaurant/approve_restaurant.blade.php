@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<div class="page-content">
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0 font-size-18">Approve Restaurant</h4>



        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row">
      <div class="col-12">
        <div class="card">

          <div class="card-body">

            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Status</th>
                  <th>Action </th>
                </tr>
              </thead>


              <tbody>
                @foreach ($client as $key=> $item)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td><img src="{{ (!empty($item->photo)) ? url('upload/client_images/'.$item->photo) : url('upload/no_image.jpg') }}" alt="" style="width: 70px; height:40px;"></td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->email }}</td>
                  <td>{{ $item->phone }}</td>
                  <td>
                    @if ($item->status == 1)
                    <span class="text-success"><b>Active</b></span>
                    @else
                    <span class="text-danger"><b>InActive</b></span>
                    @endif
                  </td>

                  <td>
                    <div class="form-check-danger form-check form-switch">
                      <input class="form-check-input status-toggle large-checkbox" type="checkbox" id="flexSwitchCheckCheckedDanger" data-id="{{$item->id}}" {{ $item->status ? 'checked' : '' }}>
                      <label class="form-check-label" for="flexSwitchCheckCheckedDanger"> </label>
                    </div>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>

          </div>
        </div>
      </div> <!-- end col -->
    </div> <!-- end row -->


  </div> <!-- container-fluid -->
</div>

<script type="text/javascript">
  $(function() {
    $('.status-toggle').change(function() {
      var status = $(this).prop('checked') == true ? 1 : 0;
      var client_id = $(this).data('id');

      $.ajax({
        type: "GET",
        dataType: "json",
        url: '/clientChangeStatus',
        data: {
          'status': status,
          'client_id': client_id
        },
        success: function(data) {
          // console.log(data.success)

          // Start Message 

          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            icon: 'success',
            showConfirmButton: false,
            timer: 3000
          })
          if ($.isEmptyObject(data.error)) {

            Toast.fire({
              type: 'success',
              title: data.success,
            })

            setTimeout(() => {
              location.reload();
            }, 1750);

          } else {

            Toast.fire({
              type: 'error',
              title: data.error,
            })

          }

          // End Message   


        }
      });
    })
  })
</script>



@endsection