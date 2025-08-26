<?php

namespace App\Http\Controllers;

use App\Models\Chapter;

class ChapterController extends Controller
{
    public function index()
    {
        return response()->json(Chapter::all());
    }
}
