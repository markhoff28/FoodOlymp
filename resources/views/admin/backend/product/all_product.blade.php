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
          <h4 class="mb-sm-0 font-size-18">All Product</h4>

          @if (Auth::guard('admin')->user()->can('product.add'))
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <a href="{{ route('admin.add.product') }}" class="btn btn-primary waves-effect waves-light">Add Product</a>
            </ol>
          </div>
          @endif
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
                  <th>Restaurant</th>
                  <th>QTY</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th>Status</th>
                  <th>Action </th>
                  <th>Activ Product </th>
                </tr>
              </thead>


              <tbody>
                @foreach ($product as $key=> $item)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td><img src="{{ asset($item->image) }}" alt="" style="width: 70px; height:40px;"></td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item['client']['name'] }}</td>
                  <td>{{ $item->qty }}</td>
                  <td>{{ $item->price }}</td>
                  <td>
                    @if ($item->discount_price == NULL)
                    <span class="badge bg-danger">No Discount</span>
                    @else
                    @php
                    $amount = $item->price - $item->discount_price;
                    $discount = ($amount / $item->price) * 100;
                    @endphp
                    <span class="badge bg-danger">{{ round($discount) }}%</span>
                    @endif
                  </td>
                  <td>
                    @if ($item->status == 1)
                    <span class="text-success"><b>Active</b></span>
                    @else
                    <span class="text-danger"><b>InActive</b></span>
                    @endif
                  </td>

                  <td>
                    @if (Auth::guard('admin')->user()->can('product.edit'))
                    <a href="{{ route('admin.edit.product',$item->id) }}" class="btn btn-info waves-effect waves-light"> <i class="fas fa-edit"></i> </a>
                    @endif
                    @if (Auth::guard('admin')->user()->can('product.delete'))
                    <a href="{{ route('admin.delete.product',$item->id) }}" class="btn btn-danger waves-effect waves-light" id="delete"><i class="fas fa-trash"></i></a>
                    @endif
                  </td>
                  <td>
                    @if (Auth::guard('admin')->user()->can('product.status'))
                    <div class="form-check-danger form-check form-switch">
                      <input class="form-check-input status-toggle large-checkbox" type="checkbox" id="flexSwitchCheckCheckedDanger" data-id="{{$item->id}}" {{ $item->status ? 'checked' : '' }}>
                      <label class="form-check-label" for="flexSwitchCheckCheckedDanger"> </label>
                    </div>
                    @endif
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
      var product_id = $(this).data('id');

      $.ajax({
        type: "GET",
        dataType: "json",
        url: '/adminChangeStatus',
        data: {
          'status': status,
          'product_id': product_id
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