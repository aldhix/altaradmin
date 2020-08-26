@props([])
<a href="{{route('admin.logout')}}" class="dropdown-item"
    onclick="event.preventDefault(); document.getElementById('logout-page').submit();" 
    class="dropdown-item"> {{ $slot }}
    <form id="logout-page" action="{{ route('admin.logout') }}" method="post" style="display: none;">@csrf</form>
</a