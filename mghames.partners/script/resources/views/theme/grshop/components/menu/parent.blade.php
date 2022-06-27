@if(!empty($menus))
@php
$mainMenus=$menus['data'] ?? [];

@endphp
@foreach ($mainMenus ?? [] as $row) 

@if (isset($row->children))

<li>
	<a  href="javascript:void(0)" >
		{{ $row->text }}  
		
	</a>
	<ul class="dropdown" >
		@foreach($row->children as $childrens)
		
		@include('theme.grshop.components.menu.child', ['childrens' => $childrens])
		@endforeach
	</ul>
</li>

@else
<li >
	<a @if(url()->current() == url($row->href)) class="active" @endif href="{{ url($row->href) }}" @if(!empty($row->target)) target="{{ $row->target }}" @endif>{{ $row->text }} 

	</a>
</li>
@endif


@endforeach
@endif