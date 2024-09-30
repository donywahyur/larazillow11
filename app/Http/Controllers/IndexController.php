<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IndexController extends Controller
{
    //
    function index()
    {
        $listing = Listing::where("baths", ">", "2")->get();
        return Inertia(
            "Index/Index",
            [
                'message' => "Hello World",
            ]
        );
    }
    function show()
    {
        return Inertia("Index/Show");
    }
}
