<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use File;
use Image;
use Illuminate\Support\Facades\Storage;
use Str;
use Auth;
use App\Models\User;

class MediaController extends Controller
{

    protected $filename;
    protected $ext;
    protected $fullname;
    protected $extension;

    public function __construct()
    {
       $this->middleware('auth');;
    }

    public function bulk_upload()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
        $row=Media::latest()->select('id','url')->paginate(12);
        return response()->json($row);


    }

    public function json(Request $request){

        $row=Media::latest()->select('id','url')->paginate(12);
        return response()->json($row);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        abort_if(!getpermission('website_settings'),401);

       $sum=Media::sum('size');
       if ((int)tenant('storage_limit') != -1) {
           if ((int)tenant('storage_limit') <= $sum) {
               $errors='Maximum Storage Limit exceeded';
               return response()->json($errors,401);
           }
       }
      

       request()->validate([
        'media.*' => 'required|image|max:3000'

       ]);

       $is_onwer=0;
       $total_file_size=$request->file('media')->getSize();;
       $driver=env('STORAGE_TYPE');

       $auth_id=tenant('uid');
       $images=[];


       $image=$request->file('media');

       $imageSizes= json_decode(imageSizes());

       $name = uniqid().date('dmy').time(). "." . strtolower($image->getClientOriginalExtension());
       $ext= strtolower($image->getClientOriginalExtension());

       $path='uploads/'.$auth_id.date('/y').'/'.date('m').'/';

        if ($driver == 'local') {
             $image->move($path, $name); 
             $schemeurl=parse_url(url('/'));
             
           
             $file_url=asset($path.$name);

            
        }
        else{
           
            Storage::disk($driver)->put($path.$name, file_get_contents(Request()->file('media')));

            $file_url= Storage::disk($driver)->url($path.$name);
            $total_file_size=Storage::disk($driver)->size($path.$name);
        }
        
        array_push($images, $path.$name);

        

        $imgArr=explode('.', $path.$name);

         foreach ($imageSizes as $size) {
             $imgname=$imgArr[0].$size->key.'.'.$imgArr[1];
             if ($driver == 'local') {
                $img=Image::make($path.$name);
                $img->fit($size->width,$size->height);
                $img->save($imgname);

                $file_size=$img->filesize();
                $total_file_size=10000+$total_file_size;
                array_push($images, $imgname);
                
             }
             else{
                $img=Image::make(Request()->file('media'))->fit($size->width,$size->height)->encode();
                Storage::disk($driver)->put($imgname, $img);
                $file_size=Storage::disk($driver)->size($imgname);
                $total_file_size=10000+$total_file_size;
                array_push($images, $imgname);
             }

             
         }

         $total_file_size=$this->getMb($total_file_size);

         $images=json_encode($images);

         $media=new Media;
         $media->url= $file_url;
         $media->driver=$driver;
         $media->files=$images;
         $media->size=$total_file_size;
         $media->is_onwer=$is_onwer;
         $media->save();


         $responseData['url']=$media->url;
         $responseData['id']=$media->id;
         return $responseData;  

   

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $media=Media::find($id);
        return response()->json($media);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


      if ($request->status=='delete') {

        $info=Options::where('key','lp_filesystem')->first();
        $info=json_decode($info->value);


        $imageSizes= json_decode(imageSizes());
        if (Auth::user()->role_id !== 1) {
         $check=true;
         $user_id=Auth::id();
         }
         else{
            $check=false;
         }
        if ($request->id) {
            foreach ($request->id as $id) {
                if ($check==true) {
                   $media=Media::where('user_id',$user_id)->findorFail($id);
                }
                else{
                   $media=Media::find($id);
                }

                if ($info->system_type=='do') {

                  $check=  Storage::disk('do')->delete($media->path.'/'.$media->name);
                    foreach ($imageSizes as $size) {
                        $imgArr=explode('.', $media->name);

                      $check=  Storage::disk('do')->delete($media->path.'/'.$imgArr[0].$size->key.'.'.$imgArr[1]);
                     }
                }
                else{
                    $file=$media->name;

                   if (file_exists($file)) {

                     unlink($file);
                     foreach ($imageSizes as $size) {
                        $img=explode('.', $file);
                        if (file_exists($img[0].$size->key.'.'.$img[1])) {
                           unlink($img[0].$size->key.'.'.$img[1]);
                        }

                     }
                 }

             }

             Media::destroy($id);


           }
       }



     }


       return response()->json('Delete Success');
    }

    







     function getMb($set_bytes)
     {
     
     $set_kb = 1000;
     $set_mb = $set_kb * 1024;
     
     return str_replace(',','',number_format($set_bytes / $set_mb,4));

     
     }

 }