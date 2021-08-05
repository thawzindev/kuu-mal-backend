@extends('admin.layouts.master')

@section('plugin-css')
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('container')
<div class="row grid-margin">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Banned IP Address</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Banned IP Address</li>
    
            </ol>
          </nav>
        </div>

        @include('includes.errors')

        <form method="POST" action="{{ $route }}">
          @csrf

          <fieldset>
              
            <div class="form-group">
                  <label for="type-id">Ip Address<span class="text-danger">*</span></label>
                  <select class="form-control select2 form-control-lg" id="ips" name="ips[]" multiple="multiple">
                      @if(isset($ips))
                        @foreach($ips as $ip)
                          <option value="{{$ip->ip_address}}" selected="selected">{{$ip->ip_address}}</option>
                        @endforeach
                      @endif
                  </select>
            </div>



            <input class="btn btn-primary" type="submit" value="Save"> 
          </fieldset>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('plugin-js')

@endsection

@section('custom-js')


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
  <script>

  $(function() {

    $(".select2").select2({
          minimumInputLength: 2,
          tokenSeparators: [',', ' '],
          tags: true,
          multiple: true,
      });

      
  });
    
  </script>
@endsection
