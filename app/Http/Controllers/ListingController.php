<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Listing;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $listings = Listing::where('is_active', true)
            ->with('tags')
            ->latest()
            ->get();

            // return $listings;
        $tags = Tag::orderBy('name')->get();

        if ($request->has('s')) {
            $query = strtolower($request->get('s'));
            $listings = $listings->filter(function ($listings) use ($query) {
                if (Str::contains(strtolower($listings->title), $query)) {
                    return true;
                }
                if (Str::contains(strtolower($listings->company), $query)) {
                    return true;
                }
                if (Str::contains(strtolower($listings->location), $query)) {
                    return true;
                }
                // if (Str::contains(strtolower($listings->content), $query)) {
                //     return true;
                // }

                return false;
            });

        }
        if ($request->has('tag')) {
            $tag = $request->get('tag');
            $listings = $listings->filter(function ($listings) use ($tag) {
                return $listings->tags->contains('slug' ,$tag);
            });
        }

        return view('listings.index', compact('listings', 'tags'));
    }

    public function show(Listing $listing, Request $request)
    {
        return view('listings.show', compact('listing'));
    }
}
