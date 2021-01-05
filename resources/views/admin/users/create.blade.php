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
          <h4 class="card-title">Add New User</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ route('admin.users.index') }}">Users</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
          </nav>
        </div>

        @include('includes.errors')

        <form method="POST" action="{{ route('admin.users.store') }}">
          @csrf

          <fieldset>
            <!-- name -->
            @component('components.textbox')
              @slot('title', 'Name (required)')  
              @slot('name', 'name')
              @slot('placeholder', 'Enter Username')
              @slot('value', isset($user) ? $user->name : '')
              @slot('autofocus', 'autofocus')
              @slot('required', 'required')
            @endcomponent

            <!-- email -->
            @component('components.textbox')
              @slot('type', 'email')
              @slot('title', 'Email (required)')  
              @slot('name', 'email')
              @slot('placeholder', 'Enter Email')
              @slot('value', isset($user) ? $user->email : '')
              @slot('required', 'required')
            @endcomponent

            <!-- phone -->
            @component('components.textbox')
              @slot('type', 'phone')
              @slot('title', 'Phone (required)')  
              @slot('name', 'phone')
              @slot('placeholder', 'Enter Phone')
              @slot('value', isset($user)? $user->phone: '')
              @slot('required', 'required')
            @endcomponent
            
            <!-- role -->
            @component('components.selectbox-with-array')
              @slot('title', 'Role (required)')
              @slot('name', 'role')
              @slot('objects', $roles)
              @slot('objectName', 'name')
              @slot('selected', '')
            @endcomponent

            <!-- password -->
            @component('components.textbox')
              @slot('type', 'password')
              @slot('title', 'Password (required)')  
              @slot('name', 'password')
              @slot('placeholder', 'Enter Password')
              @slot('value', '')
              @slot('required', 'required')
            @endcomponent

            <!-- confirm password -->
            @component('components.textbox')
              @slot('title', 'Confirm Password (required)')  
              @slot('name', 'password_confirmation')
              @slot('type', 'password')
              @slot('placeholder', 'Enter Confirm Password')
              @slot('value', '')
              @slot('required', 'required')
            @endcomponent

            {{-- Using sample components --}}
            @component('components.selectbox-with-object')
              @slot('title', 'Ajax Select2 Sample (required)')
              @slot('name', 'role2')
              @slot('objectName', 'name')
              @slot('selected', '')
            @endcomponent

            @component('components.selectbox-with-object')
              @slot('title', 'Ajax Multiple Select2 Sample (required)')
              @slot('name', 'role3[]')
              @slot('objectName', 'name')
              @slot('selected', '')
              @slot('multiple', 'multiple')
            @endcomponent

            @component('components.textareabox')
              @slot('title', 'Address (optional)')
              @slot('name', 'address')
              @slot('value', '')
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
<script src="{{ asset('assets/vendors/summernote/dist/summernote-bs4.min.js') }}"></script>
@endsection

@section('custom-js')
  @include('includes.select2-ajax-script', ['id' => '#role2', 'url' => route('admin.users.index')])
  @include('includes.select2-ajax-script', ['id' => '#role3', 'url' => route('admin.users.index')])
  <script>
    $(function () {
      $('#address').summernote({
        height: 300,
        tabsize: 1
      });

    })
  </script>
@endsection
