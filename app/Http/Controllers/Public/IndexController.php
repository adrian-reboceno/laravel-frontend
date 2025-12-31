<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    //
    public function index(): View
    {
        // Ajusta al blade real que tengas:
        return view('pages.public.index');
    }
}
