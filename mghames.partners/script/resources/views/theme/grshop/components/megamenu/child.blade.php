@if ($childrens)
<li>
   @if (isset($childrens->children)) 
   <a ref="{{ url($childrens->href) }}" @if(!empty($childrens->target)) target="{{ $childrens->target }}" @endif>{{ $childrens->text }} <i class="icofont-caret-right"></i></a>

   <ul class="sub-category" >
      @foreach($childrens->children ?? [] as $row)
      @include('theme.grshop.components.megamenu.child', ['childrens' => $row])
      @endforeach
      
   </ul>
   @else
   <a href="{{ url($childrens->href) }}" target="{{ $childrens->target }}">{{ $childrens->text }}</a>
   @endif
</li>
@endif
