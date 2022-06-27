  (function ($) {
   "use strict";
   var short=1;
   const parentAttributes= JSON.parse($('#parentattributes').val());
  
   $('.product_type').on('change',function(){
      var product_type=$(this).val();
     // alert(product_type)
      if (product_type == 1) {
         $('.single_product_price_area').hide();
         $('.variation_select_area').show();
      }
      else{
         $('.single_product_price_area').show();
         $('.variation_select_area').hide();
      }
   });
   
   //on change event will execute when change parent attribute
   $(document).on('change','.parentattribute',function(argument) {
      var variations=$('option:selected', this).data('childattributes');
     
      var short= $('option:selected', this).data('short');
      var parent_name=$('option:selected', this).data('parentname');
      var parent_id= parseInt($(this).val()); 
      $('.renderchild'+short).removeClass('parent_area'+parent_id);
      
      if (document.getElementsByClassName("parent_area"+parent_id).length > 0) {
         
         $(this).val('');
         return true;
      }

      $('.childattr'+short).remove();

      $('.renderchild'+short).addClass('parent_area'+parent_id);

      $.each(variations, function (key, item) 
      {
         var html=`<option value="${item.id}" data-parentid="${parent_id}" data-parent="${parent_name}" data-short="${short}" data-attrname="${item.name}" class='child_attr${item.id} childattr${short}'>${item.name}</option>`;
         $('.childattribute'+short).append(html);
      });

      $('.multi-select').select2()

      
      if(document.getElementById("children_attribute_render_area"+short) == null)
      {
         var html=`<div id="children_attribute_render_area${short}"></div>`;
         $('.children_attribute_render_area').append(html);
      }
   });

   //this event will execute when children attribute change
   $(document).on('change','.childattribute',function (argument) {
      var short=$('option:selected', this).data('short');
      var parent_name=$('option:selected', this).data('parent');
      var parentid=$('option:selected', this).data('parentid');
      var selected_child_ids=$(this).val();

      // $(this).attr('name',"childattribute["+parentid+"][]");
      $('.selecttype'+short).attr('name',"childattribute[options]["+parentid+"][select_type]");
      $('.is_required'+short).attr('name',"childattribute[options]["+parentid+"][is_required]");

      //select name from selected options
      var namearray = $('option:selected', this).toArray().map(item => item.text).join();
      var names=namearray.split(',');

      var selected = $(this).find('option:selected');
      var unselected = $(this).find('option:not(:selected)');
      

      $.each(unselected, function(index, value){
          $('#childcard'+$(this).val()).remove();
       });

      var unselectedparentAttr = $('.parentattribute'+short).find('option:not(:selected)');
     
      $.each(unselectedparentAttr, function(index, value){
         
          $(this).attr('disabled','');
       });

      $.each(selected_child_ids, function (index, id) {
         if(document.getElementById("childcard"+id) == null)
         {
         var html=`<div class="card " id="childcard${id}">
                  <div class="card-header">
                     <h4>${parent_name} / <span class="text-danger">  ${names[index]}</span></h4>
                  </div>
                  <div class="card-body row">
                      <div class="from-group col-lg-6">
                        <label for="" >Price : </label>
                        <div >
                           <input type="number" step="any" class="form-control" name="childattribute[priceoption][${parentid}][${id}][price]"/>
                        </div>
                     </div>
                      <div class="from-group col-lg-6  mb-2">
                        <label for="">Stock Quantity : </label>
                        <div >
                           <input type="number" class="form-control" name="childattribute[priceoption][${parentid}][${id}][qty]"/>
                        </div>
                     </div>
                     <div class="from-group col-lg-6 mb-2">
                        <label for="" >SKU : </label>
                        <div >
                           <input type="text" class="form-control" name="childattribute[priceoption][${parentid}][${id}][sku]"/>
                        </div>
                     </div>
                      <div class="from-group col-lg-6  mb-2">
                        <label for="" >Weight : </label>
                        <div >
                           <input type="number" step="any" class="form-control" name="childattribute[priceoption][${parentid}][${id}][weight]"/>
                        </div>
                     </div>
                     <div class="from-group col-lg-6  mb-2">
                        <label for="" >Manage Stock ? </label>
                        <div>
                           <select class="form-control select2" name="childattribute[priceoption][${parentid}][${id}][stock_manage]">
                              <option value="1">Yes</option>
                              <option value="0" selected>No</option>
                           </select>
                        </div>
                     </div>
                     <div class="from-group col-lg-6  mb-2">
                        <label for="" >Stock Status: </label>
                        <div>
                           <select class="form-control select2" name="childattribute[priceoption][${parentid}][${id}][stock_status]">
                              <option value="1">In Stock</option>
                              <option value="0">Out Of Stock</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>`;
        $('#children_attribute_render_area'+short).append(html);  
        }
      });
      $('.select2').select2()
   });

   //add more attributes
   $('.add_more_attribute').on('click',function(e){
      if (parentAttributes.length <= $('.parentattribute').length) {
         return true;
      }
      short++;
      var selected_options=[];
      $(".parentattribute option:selected").each(function()
      {
         if ($(this).val() != '') {
             selected_options.push(parseInt($(this).val()));
         }
      });
      var options='';
      $.each(parentAttributes, function (index, row) {
         var childs=[];

         $.each(row.categories,(i, child)=>{
            var childarray={
               "id":child.id,
               "name":child.name
            };
            childs.push(childarray);
         });
         childs=JSON.stringify(childs);
         
        if (jQuery.inArray(row.id, selected_options) == -1) {
         options +=`<option value="${row.id}"  class="parentAttr${row.id}" data-parentname="${row.name}" data-short="${short}" data-childattributes='${childs}'>${row.name}</option>`;
        }
      });
      if (options == '') {
         return true;
      }  
      var html=`<div class="renderchild${short} "><div class="card-header"><h4>Add Variation</h4><div class="card-header-action">
                      <a class="btn btn-icon btn-danger delete_attribute" data-short="${short}" href="javascript:void(0)"><i class="fas fa-times"></i></a>
                    </div></div><div class="card-body">
                     <div class="row mb-2 " >
                        <div class="col-lg-6 from-group">
                             <label for="" >Select Attribute : </label>
                           <select required name="parentattribute[]"  class="form-control parentattribute select2 parentattribute${short}">
                           <option value="" disabled  selected>Select Attribute</option>
                           ${options}
                              
                           </select>
                        </div>
                        <div class="col-lg-6 from-group">
                             <label for="" >Select Attribute Values : </label>
                           <select required   class="form-control select2 childattribute childattribute${short} multi-select" multiple="">
                              
                           </select>
                        </div>
                        <div class="from-group col-lg-6  mb-2">
                        <label for="" >Select Type : </label>
                        <div >
                           <select class="form-control select2 selecttype${short}">
                              <option value="1">Multiple Select</option>
                              <option value="0">Single Select</option>
                           </select>
                        </div>
                     </div>
                     <div class="from-group col-lg-6  mb-2">
                        <label for="" >Is Required ? : </label>
                        <div >
                           <select class="form-control select2 is_required${short}">
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                           </select>
                        </div>
                     </div>
                     </div>
                  </div>
               <div id="children_attribute_render_area${short}">
               </div></div>`;

      $('.attribute_render_area').append(html);

      $('.select2').select2();
   });

   //remove attribute area
  $(document).on('click','.delete_attribute',function (argument) {
   var id=$(this).data('short');
   $('.renderchild'+id).remove();
  });

})(jQuery);