<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
//        return new PropertyCollection(Property::limit(5)->with('options')->get());
        return PropertyResource::collection(Property::paginate(5));
//        return PropertyResource::collection(Property::limit(5)->with('options')->get());
//        return new PropertyResource(Property::find(1));
    }
}
