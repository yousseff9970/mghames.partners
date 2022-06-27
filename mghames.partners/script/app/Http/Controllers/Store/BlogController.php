<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;
class BlogController extends Controller
{
    public function index(Request $request)
    {
        $home_data=optionfromcache('blog_page');

        $seo=$home_data->seo ?? '';
        SEOMeta::setTitle($seo->site_title ?? '');
        SEOMeta::setDescription($seo->description ?? '');
       

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->site_title ?? '');

        OpenGraph::addProperty('keywords', $seo->tags ?? '');

        TwitterCard::setTitle($seo->site_title ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($seo->site_title ?? '');
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->meta_image ?? '');

        SEOTools::setTitle($seo->site_title ?? '');
        SEOTools::setDescription($seo->description ?? '');
        SEOTools::opengraph()->setUrl(url('/'));
        SEOTools::setCanonical(url('/'));
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        $page_data=$home_data->meta ?? '';

         $posts=Term::query()->where('type','blog')->where('status',1)->with('preview','excerpt');
         if (!empty($request->src)) {
             $posts=$posts->where('title','LIKE','%'.$request->src.'%');
         }
         $posts=$posts->latest()->paginate(12);
         return  view(baseview('blog/index'),compact('posts','page_data'));
    }

    public function show($slug)
    {
        $info=Term::query()->where('type','blog')->where('status',1)->where('slug',$slug)->with('excerpt','description','preview')->first();
        abort_if(empty($info),404);
        $recent_posts=Term::query()->where('type','blog')->where('status',1)->with('preview')->latest()->take(3)->get();

        JsonLdMulti::setTitle($info->title ?? '');
        JsonLdMulti::setDescription($info->excerpt->value ?? '');
        JsonLdMulti::addImage(asset($info->preview->value ?? ''));

        SEOMeta::setTitle($info->title ?? '');
        SEOMeta::setDescription($info->excerpt->value ?? '');
     
        SEOTools::setTitle($info->title ?? '');
        SEOTools::setDescription($info->excerpt->value ?? '');
     
        SEOTools::opengraph()->addProperty('image', asset('uploads/'.tenant('uid').'/logo.png'));
        SEOTools::twitter()->setTitle($info->title ?? '');
        SEOTools::twitter()->setSite($info->title ?? '');
        SEOTools::jsonLd()->addImage(asset($info->preview->value ?? ''));
        
        return  view(baseview('blog/show'),compact('info','recent_posts'));
    }
}
