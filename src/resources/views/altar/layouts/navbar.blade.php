<x-slot name="left">
	<li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
     <x-alt-navbar-menu label="Home" href="#" />
     <x-alt-navbar-menu label="Contact" href="#" />
</x-slot>

<x-slot name="right">
	<x-alt-navbar-menu :dropdown="true" size="md">
	    <x-slot name="label">
	      <i class="fas fa-users-cog"></i> {{Altaradmin::user()->name}} 
	    </x-slot>
	    <a href="{{route('admin.profile')}}" class="dropdown-item">
	      <i class="fas fa-user mr-2"></i> My Profile
	    </a>
	     <a href="{{ route('demo.about') }}" class="dropdown-item">
	      <i class="fas fa-exclamation-circle mr-2"></i> About
	    </a>
	    <div class="dropdown-divider"></div>
		<x-alt-navbar-logout>
			<i class="fas fa-sign-out-alt mr-2"></i> Logout
		</x-alt-navbar-logout>
	</x-alt-navbar-menu>
</x-slot>
