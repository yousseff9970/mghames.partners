<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
class MedialistController extends Controller
{
    public function index()
    {
        abort_if(!getpermission('website_settings'),401);
        $medialists = Media::query()->latest()->paginate(30);
        return view('seller.media.index',compact('medialists'));
    }

    public function create()
    {
         abort_if(!getpermission('website_settings'),401);
        return view('seller.media.upload');
    }

    public function delete(Request $request)
    {
         abort_if(!getpermission('website_settings'),401);
        if($request->id)
        {
            if($request->status == 'delete')
            {
                $storage_files=[];
                foreach ($request->id as $value) {
                    $media = Media::find($value);
     
                    if (!empty($media)) {
                        $files = json_decode($media->files);
                        
                        foreach ($files as $file) {
                           if ($media->driver == 'local') {
                            if (file_exists($file)) {
                                 unlink($file);
                            }
                            
                           }
                           else{
                            $storage_files[$media->driver][]=$file;
                           }
                           
                        }

                        

                       $media->delete();
                    }
     
                 }
                try {
                    foreach ($storage_files ?? [] as $key => $value) {
                        if ($key != 'default') {
                           Storage::disk($key)->delete($value);
                        }
                       
                    }
                    
                } catch (Exception $e) {

                }
                 return response()->json('Media Deleted');
            }else{
                $errors['errors']['error']='Opps! Please select Any Status.';
                return response()->json($errors,401);
            }
        }else{
            $errors['errors']['error']='Opps! Please select Any Status.Please select any checkbox.';
            return response()->json($errors,401);
        } 
    }
}
