@if(!empty($menus))
	@php
	$mainMenus=$menus['data'] ?? [];
	
	@endphp
	@foreach ($mainMenus ?? [] as $row) 
	<li>
		@if (isset($row->children))
		
		<a href="javascript:void(0)">
			{{ $row->text }}  <b class="span-dot"><span class="span-circle"></span></b>
			<div class="drop-icon"><i class="icofont-simple-down"></i></div>
		</a>
		<ul class="submenu" id="submenu-1-5">
			@foreach($row->children as $childrens)
			<!-- <li class="nav-item"><a href="dashboard.html">dashboard</a></li> -->
			@include('layouts.frontend.components.menu.child', ['childrens' => $childrens])
			@endforeach
		</ul>

		@else
		<a @if(url()->current() == url($row->href)) class="active" @endif href="{{ url($row->href) }}" @if(!empty($row->target)) target="{{ $row->target }}" @endif>{{ $row->text }} 
			@if(url()->current() == url($row->href))
			  <b class="span-dot"><span class="span-circle"></span></b>
			@endif
		</a>
		@endif
	</li>

	@endforeach
@endif