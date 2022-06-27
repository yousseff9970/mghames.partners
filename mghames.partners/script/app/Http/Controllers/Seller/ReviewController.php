<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Term;

use Illuminate\Http\Request;
use Auth;

class ReviewController extends Controller
{
    public function index()
    {
        abort_if(!getpermission('reviews'),401);
        $reviews = Review::whereHas('order')->whereHas('user')->with('order','user')->latest()->paginate(20);
        return view('seller.review.index',compact('reviews'));
    }

    public function destroy(Request $request)
    {
         abort_if(!getpermission('reviews'),401);
        if($request->method == 'delete')
        {
            if($request->id)
            {
                foreach ($request->id as $key => $value) {
                   $review = Review::find($value);
                   $review->delete();

                   $term=Term::find($review->term_id);
                   $term->rating=number_format(Term::avg('rating'),2);
                   $term->save();
                }

                return response()->json('Review Successfully Deleted!');
            }else{
                $errors['errors']['error']='Please Select Any Review.';
                return response()->json($errors,401);
            }
        }else{
            $errors['errors']['error']='Please Select Any Status.';
            return response()->json($errors,401);
        }
    }
}
