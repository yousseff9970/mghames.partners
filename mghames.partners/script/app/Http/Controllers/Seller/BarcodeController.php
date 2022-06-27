<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use DNS1D;
use DNS2D;
use Auth;


class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!getpermission('products'),401);
         abort_if(tenant('barcode') != 'on',401);
        return view('seller.product.barcode');
    }

    


    public function search(Request $request)
    {
        $search = $request->search;
        $product = Term::with('firstprice')->where([
            ['type','product'],
            ['status',1],
            ['full_id', 'LIKE', "%$search%"]
        ])->paginate(10);

        return response()->json($product);
    }

    
    public function generate(Request $request)
    {
       
        if($request->product)
        {
            foreach ($request->product as $key => $value) {
                $product = Term::with('firstprice','preview')->where('full_id',$value)->first();
                $barcodes[] = $product->full_id;
                if($request->barcode_type == 'QRCODE' || $request->barcode_type == 'PDF417')
                {
                    $barcode = DNS2D::getBarcodePNG($product->full_id, $request->barcode_type, 100, 100);
                }else{
                    $barcode = DNS1D::getBarcodePNG($product->full_id, $request->barcode_type);
                }
                $barcodes[$key] = ['barcode' => $barcode, 'product' => $product]; 
            }

            $currency = get_option('currency_data',true)->currency_name;
            

            return response()->json(['barcodes'=>$barcodes,'currency'=>$currency]);
        }else{
            $error['errors']['barcode']='Oops! Please Add Some Product.';
            return response()->json($error,422);
        }
    }

    
}
