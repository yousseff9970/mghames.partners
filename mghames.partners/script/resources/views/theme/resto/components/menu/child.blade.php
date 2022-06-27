@if ($childrens)
<li class="nav-item">
	@if (isset($childrens->children)) 
	<a class="page-scroll dd-menu collapsed" @if(url()->current() == url($row->href)) class="active" @endif href="{{ url($childrens->href) }}" @if(!empty($childrens->target)) target={{ $childrens->target }} @endif

		data-bs-toggle="collapse" data-bs-target="#submenu-1-4" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		{{ $childrens->text }}</b>
		
	</a>
	
	<ul class="sub-menu collapse" id="submenu-1-4">
		@foreach($childrens->children ?? [] as $row)
		@include('theme.resto.components.menu.child', ['childrens' => $row])
		@endforeach
		
	</ul>
	@else
	<a href="{{ url($childrens->href) }}">{{ $childrens->text }}</a>
	@endif
</li>
@endif


