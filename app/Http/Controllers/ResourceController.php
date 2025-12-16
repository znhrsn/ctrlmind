<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource; // assuming you have a Resource model

class ResourceController extends Controller
{
    public function index(){
    $featuredResources = Resource::where('is_featured', true)->take(3)->get();

    $educational = Resource::where('section', 'Educational Corner')->get();
    $coping = Resource::where('section', 'Coping & Self-Care Strategies')->get();
    $help = Resource::where('section', 'Getting Help')->get();

    return view('resources.index', compact('featuredResources', 'educational', 'coping', 'help'));
    }

    public function show(Resource $resource)
{
    return view('resources.show', compact('resource'));
}

}