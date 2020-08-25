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
          <th>Name</th><th>Email</th><th>&nbsp;</th>
        </x-slot>
        
        @foreach($data as $td)
        <tr>
          <td>{{$td['name']}}</td><td>{{$td['email']}}</td>
          <td>
          @if(Auth::guard('admin')->id() == $td['id'])
            <x-alt-action 
            :edit="route('admin.edit',['admin'=>$td['id']])" />
          @elseif( $td['id'] != 1)
            <x-alt-action 
            :edit="route('admin.edit',['admin'=>$td['id']])" 
            :delete="route('admin.destroy',['admin'=>$td['id']])" />
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