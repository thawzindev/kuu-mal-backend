@extends('admin.layouts.master')

@section('plugin-css')
<style>
  .modal-content{
    background: #fff !important;
  }
</style>
@endsection

@section ('container')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-baseline">
          <h4 class="card-title mr-auto">Volunteers</h4>
        

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Volunteers</li>
            </ol>
          </nav>

        </div>

        <form action="{{ route('admin.volunteers.index') }}" method="GET" 
              class="row">


          <!-- state -->
          <div class="form-group col-3">
            <label for="role">State</label>
            <select class="form-control" name="state_id">
              <option value="">All</option>
              @foreach($states as $state)
                <option value="{{ $state['id'] }}" {{ request('state_id') == $state['id'] ? 'selected' : '' }}>
                  {{ $state['name'] }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group col-3">
            <label for="keyword">Keyword</label>
            <input type="text" class="form-control form-control-sm" name="keyword" value="{{ request('keyword') }}">
          </div>

          <div class="col-3">
            <label></label>
            <input class="btn btn-success mt-3" type="submit" value="Search"> 
          </div>

        </form>
        <!-- /.d-flex -->

        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <table id="order-listing" class="table">
                <thead>
                  <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Activities</th>
                    <th>IP</th>
                    <th>Is Complete</th>
                    <th>State</th>
                    <th>Township</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($requests as $index => $request)
                  <tr>
                    <td>{{ $requests->firstItem() + $index }}</td>
                    <td>{{ $request->name }}</td>
                    <td>{{ $request->phone }}</td>
                    <td title="{{ $request->address }}"> 
                        {!! str_limit($request->address, 30) !!}
                    </td>
                    <td title="{{ $request->activities }}"> 
                        {!! str_limit($request->activities, 30) !!}
                    </td>

                    <td> 
                        <label class="badge badge-info">{{ $request->ip_address }}</label>
                    </td>

                    <td> 
                        <label class="badge badge-{{ $request->label() }}">{{ $request->isComplete() }}</label>
                    </td>
                    <td> 
                        <label class="badge badge-info">{{ $request->state ? $request->state->name : ''}}</label>
                    </td>
                    <td> 
                        <label class="badge badge-dark">{{ $request->township ? $request->township->name : '' }}</label>
                    </td>
                    
                    <td class="text-center">

                      <a href="{{ route('admin.requests.status_update', $request) }}" class="btn btn-{{ $request->buttonLabel() }} btn-sm">
                        {{ $request->isCompleteButton() }}
                      </a>

                      @if($request->ip_address)
                        <a href="{{ route('admin.ips.ban', $request->ip_address) }}" class="btn btn-dark btn-sm">
                          Ban IP
                        </a>
                      @endif

                      <a href="{{ route('admin.requests.edit', $request) }}" class="btn btn-icons btn-light">
                        <span class="fa fa-edit fa-lg text-primary"></span></a>

                      <button type="button" class="btn btn-icons btn-light confirm-button" data-toggle="modal" data-target="#myModal" data-id="{{ $request->id }}">
                        <span class="fa fa-trash fa-lg text-danger"></span>
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.col -->

          <!-- pagination -->
          <nav class="col-12 d-flex justify-content-end mt-4">
            {{ $requests->appends($_GET)->links() }}
          </nav>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
      
      <!-- confirm modal box -->
      @include('components.confirm-modal', ['modal' => 'myModal', 'header' => 'Delete request', 'body' => 'Are you sure delete this request?', 'button_color' => 'danger', 'button_text' => 'Delete', 'confirm' => 'request', 'method' => 'DELETE'])
      <!-- end confirm modal box  -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
@endsection

@section('plugin-js')

@endsection

@section('custom-js')
@php 
  if (request('date')) {
    $date = split_daterange(request('date')); 
  }
@endphp

<script>
  $(function () {
    // Date range picker
    @if(request('date'))
      var start = moment('{{ $date['from'] }}');
      var end = moment('{{ $date['to'] }}');
    @else
      var start = moment().startOf('month');
      var end = moment().endOf('month');
    @endif

    function cb(start, end) {
      $('#daterange input').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
    }

    $('#daterange').daterangepicker({
      locale: {
          format: 'YYYY/MM/DD'
      },

      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Year': [moment().startOf('year'), moment().endOf('year')],
        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
      },

    }, cb); 

    cb(start, end); 
    /** --- end daterangepicker --- */

   //modal box
   $('.confirm-button').click(function(){
       let request = $(this).data('id')
       console.log(request)
       let url = "{{ route('admin.requests.destroy', ':request') }}"
       url  = url.replace(':request', request)

       $('#request').attr('action', url)

    })

  });
</script>
@endsection