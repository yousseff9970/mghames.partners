@if(!empty($menus))
@if(!empty($menus['data'] ?? []))
<div class="all-category">
   <h3 class="cat-heading">
      <b class="start-icon"><i class="icofont-navigation-menu" aria-hidden="true"></i></b>
      <span class="megamenu_name">{{ $menus['name'] ?? '' }}</span>
      <b class="down-icon"><i class="icofont-caret-down"></i></b>
   </h3>
   <ul class="main-category main-menu-cat">
      @foreach ($menus['data'] ?? [] as $row) 
         @if (isset($row->children))
         <li>
         <a  href="javascript:void(0)" >
            {{ $row->text }}  
            <i class="icofont-caret-right"></i>
         </a>
         <ul class="sub-category" >
            @foreach($row->children as $childrens)

            @include('theme.grshop.components.megamenu.child', ['childrens' => $childrens])
            @endforeach
         </ul>
         </li>
         @else

         <li><a  href="{{ $row->href }}" @if(!empty($row->target)) target="{{ $row->target }}" @endif>{{ $row->text }} </a></li>
         @endif
      @endforeach
      
     
   </ul>
</div>
@endif
@endif