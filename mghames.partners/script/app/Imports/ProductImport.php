<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Term;
use DB;
class ProductImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
       ini_set('max_execution_time', '0');
       $limit=postlimitcheck(false);

       $posts_count=$limit;
       foreach ($rows as $key => $row) {

         DB::beginTransaction();
         try { 

           if ($limit <= $posts_count) {

               \Session::flash('error', 'Maximum posts limit exceeded');
               return back();
               break;
               
           }
            
           $term=new Term;
           $term->title = $row[0];
           $term->slug=$term->makeSlug($row[0],'product');
           $term->type='product';
           $term->status=1;
           $term->save();

           if (isset($row[5])) {
                if (!empty($row[5])) {
                   $term->meta()->create(['key'=>'excerpt','value'=>$row[5]]);
                }
             
           }

           $term->price()->create(['price'=>$row[1],'qty'=>$row[2],'sku'=>$row[3],'weight'=>$row[4]]);

           $posts_count++;

              DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            
        }  

           

       }
    }
}



















