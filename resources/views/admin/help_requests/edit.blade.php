@extends('admin.layouts.master')

@section('plugin-css')
 <link rel="stylesheet" href="{{ asset('assets/vendors/summernote/dist/summernote-bs4.css') }}">
@endsection

@section('container')
<div class="row grid-margin">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Help</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ route('admin.requests.index') }}">Help</a>
              </li>
              @if(isset($request))
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
              @else
                <li class="breadcrumb-item active" aria-current="page">Create</li>
              @endif
            </ol>
          </nav>
        </div>

        @include('includes.errors')

        <form method="POST" action="{{ $route }}">
          @csrf
          @if(ends_with(request()->url(), '/edit'))
            @method("PATCH")
          @endif


          <fieldset>
            <!-- name -->
            @component('components.textbox')
              @slot('title', 'Name')  
              @slot('name', 'name')
              @slot('placeholder', 'Enter Username')
              @slot('value', isset($request) ? $request->name : '')
              @slot('autofocus', 'autofocus')
              @slot('required', '')
            @endcomponent

            <!-- phone -->
            @component('components.textbox')
              @slot('type', 'phone')
              @slot('title', 'Phone')  
              @slot('name', 'phone')
              @slot('placeholder', 'Enter Phone')
              @slot('value', isset($request) ? $request->phone: '')
              @slot('required', 'required')
            @endcomponent
            
            <!-- states -->
            @component('components.selectbox-with-array')
              @slot('title', 'State')
              @slot('name', 'state_id')
              @slot('objects', $states)
              @slot('objectName', 'name')
              @slot('selected', isset($request) ? $request->state_id : '')
            @endcomponent

            <!-- township -->
            @component('components.selectbox-with-array')
              @slot('title', 'Township')
              @slot('name', 'township_id')
              @slot('objects', [])
              @slot('objectName', 'name')
              @slot('selected', '')
            @endcomponent

            <!-- activities -->
            @component('components.textareabox')
              @slot('title', 'Activities')
              @slot('name', 'activities')
              @slot('value', isset($request) ? $request->activities : '')
              @slot('required', 'required')
            @endcomponent

            <!-- Address -->
            @component('components.textareabox')
              @slot('title', 'Address')
              @slot('name', 'address')
              @slot('value', '')
              @slot('value', isset($request) ? $request->address : '')
              @slot('required', 'required')
            @endcomponent

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
  @include('includes.select2-ajax-script', ['id' => '#role2', 'url' => route('admin.requests.index')])
  @include('includes.select2-ajax-script', ['id' => '#role3', 'url' => route('admin.requests.index')])
  <script>

    $(function() {

      // if(!$('#state_id').val()){
      //   $("#township_id").append(`<option> --Select Township-- </option>`);
      // }
      
      let data = {!! isset($request) ? json_encode($request->toArray()) : 0 !!};

      if(data){
        let stateId = $('#state_id').val();
        let url = `/admin/states/${stateId}/townships`;
        getTownship(url, data.township_id)
      }else{
          $("#township_id").empty();
          // $("#township_id").append(`<option value="">Select Township</option>`)
      }

      $('#state_id').change(function(){
        let stateId = $('#state_id').val();
        let url = `/admin/states/${stateId}/townships`;
        getTownship(url, data)
      })

      /** Selected township and get townships **/
      function getTownship(url, data = null)
      {  
        $('#township_id').show();

        $.ajax({
          type: "GET",
          url,
          success: function(response){
            const townships = response;
            $("#township_id").empty();

             $("#township_id").append(`<option value="" disabled>Select Township</option>`)

            $.each(townships, function(key, township){
              $("#township_id").append(`<option value="${township.id}" ${township.id ==  data ? 'selected' : ''}>
                ${township.name}
                </option>`);
            });

          }
        })
      }

  });
    
  </script>
@endsection
