@extends('altar.layouts.app')
@section('title','Administrator')
@section('content-header')
<a href="{{ route('admin.index') }}" class="btn btn-secondary mr-2">
  <i class="fas fa-chevron-left"></i>
</a> 
Administrator
@endsection
@section('content')
<div class="row">
	<div class="col-md-6">
		<x-alt-form-card method="post" action="{{ route('admin.store') }}">
        <x-slot name="title"><i class="fas fa-plus-circle"></i> Add New</x-slot>
         @csrf()
        <x-alt-input label="Full Name" name="name" inline="true" />
        <x-alt-input label="Email Address" name="email" type="email" inline="true" />
        <x-alt-select label="Level Admin" name="level" 
         :option="[
            ['value'=>'admin','label'=>'Administrator'],
            ['value'=>'current','label'=>'Current Admin'],
         ]"
         inline="true" />
        <x-alt-input label="Password" name="password" type="password" inline="true" />
        <x-alt-input label="Confirm Password" name="password_confirmation" type="password" inline="true" />
        <x-slot name="footer">
          <x-alt-button btn="primary"><i class="fas fa-database"></i> Save Data</x-alt-button>
        </x-slot>
      </x-alt-form-card>
	</div>
</div>
@endsection