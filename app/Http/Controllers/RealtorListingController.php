<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RealtorListingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }

    public function index(Request $request)
    {
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];

        return Inertia(
            "Realtor/Index",
            [
                'filters' => $filters,
                'listings' => Auth::user()
                    ->listings()
                    ->filters($filters)
                    ->withCount('images')
                    ->paginate(5)
                    ->withQueryString()
            ]
        );
    }



    public function create()
    {
        return Inertia(
            "Realtor/Create",
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->user()->listings()->create(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:1|max:1500',
                'city' => 'required',
                'price' => 'required|integer|min:0|max:9999999',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:1000',
                'code' => 'required',
                'price' => 'required|integer|min:1|max:2000000',
            ])
        );

        return redirect()->route('realtor.listing.index')->with('success', 'Listing created successfully!');
    }

    public function edit(Listing $listing)
    {
        //
        return Inertia(
            "Realtor/Edit",
            [
                'listing' => $listing,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:1|max:1500',
                'city' => 'required',
                'price' => 'required|integer|min:0|max:9999999',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:1000',
                'code' => 'required',
                'price' => 'required|integer|min:1|max:2000000',
            ])
        );

        return redirect()->route('realtor.listing.index')->with('success', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();
        return redirect()->route('realtor.listing.index')->with('success', 'Listing deleted successfully!');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();

        return redirect()->back()->with('success', 'Listing restored successfully!');
    }
}
