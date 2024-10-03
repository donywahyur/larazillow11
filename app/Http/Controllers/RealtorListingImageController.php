<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RealtorListingImageController extends Controller
{
    //
    public function create(Listing $listing)
    {
        $listing->load(['images']);
        return Inertia(
            'Realtor/ListingImage/Create',
            ['listing' => $listing]
        );
    }
    public function store(Listing $listing, Request $request)
    {
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'required|image|mimes:jpeg,png,jpg|max:5000'
            ], [
                'images.*.mimes' => 'Only jpeg,png,jpg format is allowed.'
            ]);
            foreach ($request->file('images') as $image) {
                $path = $image->store('images');

                $listing->images()->save(new ListingImage([
                    'filename' => $path
                ]));
            }
        }
        return redirect()->back()->with('success', 'Listing images upload successfully!');
    }
    public function destroy(Listing $listing, ListingImage $image)
    {
        Storage::delete($image->filename);
        $image->delete();

        return redirect()->back()->with('success', 'Listing image deleted successfully!');
    }
}
