@extends('altar.layouts.app')
@section('title','Administrator')
@section('content-header')
<i class="fas fa-user-friends"></i> Administrator
@endsection
@section('content')

@if(session('success') == 'store')
<x-alt-alert>
  <h5><i class="icon fas fa-check"></i> Saved !</h5>
  Success saved a data.
</x-alt-alert>
@endif

@if(session('success') == 'update')
<x-alt-alert>
  <h5><i class="icon fas fa-check"></i> Updated !</h5>
  Success updated a data.
</x-alt-alert>
@endif

@if(session('success') == 'destroy')
<x-alt-alert>
  <h5><i class="icon fas fa-check"></i> Deleted !</h5>
  Success deleted a data.
</x-alt-alert>
@endif

<div class="row">
    <div class="col-12">
      
      <x-alt-table search='true'>
      	<x-slot name="header">
            <a href="{{route('admin.create')}}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle"></i> Add New</a>
        </x-slot>

        <x-slot name="thead">

        </x-slot>
        
        @foreach($data as $e)
        <tr>
          <td width="110">
            <img src="{{ url('altar/images/profile/'.$e->photo) }}" class="img-thumbnail" width="100">
          </td>
          <td>
          Name :  <strong>{{$e->name}} </strong> <br>
          Email : {{$e->email}} <br>
          Level : {{ $e->level }}
          </td>
          <td>
          @if(Auth::guard('admin')->id() == $e->id && $e->id != 1 )
            <x-alt-action 
            :edit="route('admin.edit',['admin'=>$e->id])" />
          @elseif( $e->id != 1)
            <x-alt-action 
            :edit="route('admin.edit',['admin'=>$e->id])" 
            :delete="route('admin.destroy',['admin'=>$e->id])" />
          @endif
          </td>
        </tr>
        @endforeach
        
        <x-slot name="footer">
          <div class="float-left pl-2 pt-2">Total : {{$data->total()}}</div>
          {{ $data->onEachSide(2)->appends(['keyword' => request()->keyword ])->links('altar.layouts.pagination') }}
        </x-slot>

      </x-alt-table>
    
    </div>
</div>
@endsection