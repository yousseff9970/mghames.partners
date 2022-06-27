<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Lib\Compress\Resmushit;
use Storage;
use Auth;
class ImagecompressController extends Controller
{
    protected $size=0;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
        abort_if(tenant('image_optimization') != 'on',404);
        $posts=Media::latest()->select('id','url','created_at')->where('is_optimized',0)->paginate(12);
        return view('seller.media.compress',compact('posts','request'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
         abort_if(tenant('image_optimization') != 'on',404);
        if (count($request->id ?? []) == 0) {
            $errors['errors']['error']='Select some images';
            return response()->json($errors,401);
        }

        if ($request->status != 'compress') {
            $errors['errors']['error']='Select a method';
            return response()->json($errors,401);
        }

        $method=env('IMAGE_COMPRESS_METHOD');
        foreach ($request->id as $key => $value) {
            $file=Media::find($value);
            if (!empty($file)) {
                 $pathwithfile=json_decode($file->files);
                 $pathwithfile=$pathwithfile[0];
                 $mime = explode('.',$pathwithfile);
                 $mime=end($mime);
                 $file_name=explode('/',$pathwithfile);
                 $file_name=end($file_name);

                 $is_compress=true;
                 $ready_file_content=false;
                 if ($method == 'resmushit') {
                    $resmush=new Resmushit;
                    $output=$resmush->makesmash(asset($file->url),$mime,$file_name,$request->compress);

                    if ($output == false) {
                        $is_compress=false;
                        
                    }
                    else{
                        $this->size=$this->getMb($output['size_less']);   
                    }
                    
                 }
                 elseif($method == 'tinify'){
                    $resmush=new \App\Lib\Compress\Tinify;
                    $output=$resmush->makesmash(asset($file->url));
                    $ready_file_content=true;
                    if ($output == false) {
                        $is_compress=false;
                        
                    }
                   
                 }
                 if ($is_compress == true) {
                    $compressed=$this->fileupload($output['src'],$pathwithfile,$file->driver,$ready_file_content);
                    if ($compressed == true) {
                       $newsize=$this->size;
                       $file->size=$newsize;
                       $file->is_optimized=1;
                       $file->save();

                   }
                 }
                 
                
               
            }
            

        }

        return response()->json('Compressed success');
    }

    public function fileupload($url,$name,$driver,$ready_content=false)
    {
        try {
            if ($driver != 'local') {
                Storage::disk($driver)->put($name, $ready_content == false ? file_get_contents($url) : $url);
                $size=Storage::disk($driver)->size($name);
                $this->size=$this->getMb($size+10000);
                return true;
            }

            Storage::disk('public')->put($name, $ready_content == false ? file_get_contents($url) : $url);
            $size=Storage::disk('public')->size($name);
            $this->size=$this->getMb($size+10000);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    function getMb($set_bytes){
         $set_kb = 1000;
         $set_mb = $set_kb * 1024;
         
         return str_replace(',','',number_format($set_bytes / $set_mb,4));
     }

    
}
