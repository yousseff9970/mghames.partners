@if ($childrens)
<li>
	@if (isset($childrens->children)) 
	<a @if(url()->current() == url($row->href)) class="active" @endif href="{{ url($childrens->href) }}" @if(!empty($childrens->target)) target={{ $childrens->target }} @endif>
		{{ $childrens->text }}</b>
	</a>
	
	<ul class="submenu" id="submenu-1-4">
		@foreach($childrens->children ?? [] as $row)
		@include('layouts.frontend.components.menu.child', ['childrens' => $row])
		@endforeach
		
	</ul>
	@else
	<a href="{{ url($childrens->href) }}">{{ $childrens->text }}</a>
	@endif
</li>
@endif


