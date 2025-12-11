<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource; // assuming you have a Resource model

class ResourceController extends Controller
{
    public function index()
    {
        // Paginate all resources
        $resources = Resource::paginate(9);

        // Featured resources (could be a flag in DB, or just latest few)
        $featuredResources = Resource::where('is_featured', true)->take(3)->get();

        return view('resources.index', compact('resources', 'featuredResources'));
    }
}