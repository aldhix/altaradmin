@extends('altar::page')
@section('title','My Profile')
@section('heading')
<i class="fas fa-user"></i>  My Profile
@endsection
@section('content')

@if(session('success') == 'update')
<x-alt-alert>
  <h5><i class="icon fas fa-check"></i> Updated !</h5>
  Success updated a data.
</x-alt-alert>
@endif

<div class="row">
	<div class="col-md-6">
		<x-alt-form-card method="post" action="{{ route('admin.profile') }}" enctype="multipart/form-data">
         @csrf()
         @method('put')
        <div class="form-group row">
          <div class="col-8 offset-4">
              <div class="img-preview img-thumbnail" 
              data-src="{{url('altar/images/profile/'.$data->photo) }}"
              style="background-image:url({{url('altar/images/profile/'.$data->photo) }})">
                  <div class="btn btn-sm img-remove btn-light">&#10060;</div>
                  <div class="btn btn-sm btn-info img-find"><i class="fas fa-search"></i></div>
              </div>
              <x-alt-input name="photo" class="photo" type="file" :form-group="false" accept="image/png, image/jpeg"/>
          </div>
        </div>
        <x-alt-input label="Full Name" name="name" value="{{$data->name}}" inline="true" />
        <x-alt-input label="Email Address" name="email" type="email" value="{{$data->email}}" inline="true" />
        <x-alt-input label="New Password" name="password" type="password" inline="true">
          <x-slot name="feedback">
             <div class="form-text text-muted">Type if you want to change a new password.</div>
          </x-slot>
        </x-alt-input>
        <x-alt-input label="Confirm Password" name="password_confirmation" type="password" inline="true" />

        <x-slot name="footer">
          <x-alt-button btn="primary"><i class="fas fa-database"></i> Update My Profile</x-alt-button>
        </x-slot>
      </x-alt-form-card>
	</div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{url('altar/css/profile-preview.css')}}">
@endpush

@push('js')
<script src="{{ url('altar/js/profile-preview.js') }}"></script>
@endpush