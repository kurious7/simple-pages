<?php

namespace Kurious7\SimplePages\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kurious7\SimplePages\Models\SimplePage;

class SimplePagesController extends Controller
{
    public function __invoke(Request $request, $slug)
    {
        $page = SimplePage::published()
                ->where('slug', $slug)
                ->first();

        if (!$page) {
            return abort(404);
        }

        return view('simple-pages::index', [
            'page' => $page,
        ]);
    }
}
