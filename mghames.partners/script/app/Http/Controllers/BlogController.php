<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;
class BlogController extends Controller
{
    public function show($title)
    {
        $blog = Term::with('preview','excerpt','description')->where([
            ['slug',$title],
            ['status',1],
            ['type','blog']
        ])->first();
        
        $blogs = Term::where([
            ['status',1],
            ['type','blog']
        ])->latest()->take(4)->get();

        abort_if(empty($blog),404);

        JsonLdMulti::setTitle($blog->title ?? env('APP_NAME'));
        JsonLdMulti::setDescription($blog->excerpt->value ?? null);
        JsonLdMulti::addImage(asset($blog->preview->value ?? ''));

        SEOMeta::setTitle($blog->title ?? env('APP_NAME'));
        SEOMeta::setDescription($blog->excerpt->value ?? null);
      

        SEOTools::setTitle($blog->title ?? env('APP_NAME'));
        SEOTools::setDescription($blog->excerpt->value ?? null);
        SEOTools::setCanonical(url()->current());

        SEOTools::opengraph()->addProperty('image', asset($blog->preview->value ?? ''));
        SEOTools::twitter()->setTitle($blog->title ?? env('APP_NAME'));
     
        SEOTools::jsonLd()->addImage(asset($blog->preview->value ?? ''));

       

        return view('blog.show',compact('blog','blogs'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $blogs = Term::where([
            ['title','like', "%{$search}%"],
            ['status',1],
            ['type','blog']
        ])->paginate(20);

        $recent_blogs = Term::where([
            ['status',1],
            ['type','blog']
        ])->latest()->take(4)->get();

        $seo=get_option('seo_blog',true);

        JsonLdMulti::setTitle($seo->site_name ?? env('APP_NAME'));
        JsonLdMulti::setDescription($seo->matadescription ?? null);
        JsonLdMulti::addImage(asset('uploads/logo.png'));

        SEOMeta::setTitle($seo->site_name ?? env('APP_NAME'));
        SEOMeta::setDescription($seo->matadescription ?? null);
        SEOMeta::addKeyword($seo->tags ?? null);

        SEOTools::setTitle($seo->site_name ?? env('APP_NAME'));
        SEOTools::setDescription($seo->matadescription ?? null);
        SEOTools::setCanonical(url('/'));
        SEOTools::opengraph()->addProperty('keywords', $seo->matatag ?? null);
        SEOTools::opengraph()->addProperty('image', asset('uploads/logo.png'));
        SEOTools::twitter()->setTitle($seo->site_name ?? env('APP_NAME'));
        SEOTools::twitter()->setSite($seo->twitter_site_title ?? null);
        SEOTools::jsonLd()->addImage(asset('uploads/logo.png'));

        return view('blog.list',compact('blogs','recent_blogs'));
    }

    public function lists()
    {
        $blogs = Term::where([
            ['status',1],
            ['type','blog']
        ])->paginate(20);

        $recent_blogs = Term::where([
            ['status',1],
            ['type','blog']
        ])->latest()->take(4)->get();

        $seo=get_option('seo_blog',true);

        JsonLdMulti::setTitle($seo->site_name ?? env('APP_NAME'));
        JsonLdMulti::setDescription($seo->matadescription ?? null);
        JsonLdMulti::addImage(asset('uploads/logo.png'));

        SEOMeta::setTitle($seo->site_name ?? env('APP_NAME'));
        SEOMeta::setDescription($seo->matadescription ?? null);
        SEOMeta::addKeyword($seo->tags ?? null);

        SEOTools::setTitle($seo->site_name ?? env('APP_NAME'));
        SEOTools::setDescription($seo->matadescription ?? null);
        SEOTools::setCanonical(url('/'));
        SEOTools::opengraph()->addProperty('keywords', $seo->matatag ?? null);
        SEOTools::opengraph()->addProperty('image', asset('uploads/logo.png'));
        SEOTools::twitter()->setTitle($seo->site_name ?? env('APP_NAME'));
        SEOTools::twitter()->setSite($seo->twitter_site_title ?? null);
        SEOTools::jsonLd()->addImage(asset('uploads/logo.png'));

        return view('blog.list',compact('blogs','recent_blogs'));
    }
}
