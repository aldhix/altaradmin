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
		<x-alt-form-card method="post" action="{{ route('admin.update',['admin'=>$data->id]) }}">
        <x-slot name="title"><i class="fas fa-edit"></i> Edit Data</x-slot>
         @csrf()
         @method('put')
        <x-alt-input label="Full Name" name="name" value="{{$data->name}}" inline="true" />
        <x-alt-input label="Email Address" name="email" type="email" value="{{$data->email}}" inline="true" />
        <x-alt-select label="Level Admin" name="level" value="{{$data->level}}"
         :option="[
            ['value'=>'admin','label'=>'Administrator'],
            ['value'=>'current','label'=>'Current Admin'],
         ]"
         inline="true" />
        <x-alt-input label="New Password" name="password" type="password" inline="true">
          <x-slot name="feedback">
             <div class="form-text text-muted">Type if you want to change a new password.</div>
          </x-slot>
        </x-alt-input>
        <x-alt-input label="Confirm Password" name="password_confirmation" type="password" inline="true" />

        <x-slot name="footer">
          <x-alt-button btn="primary"><i class="fas fa-database"></i> Update Data</x-alt-button>
        </x-slot>
      </x-alt-form-card>
	</div>
</div>
@endsection