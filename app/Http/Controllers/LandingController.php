<?php

namespace App\Http\Controllers;

use App\Models\Corpse;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function search(Request $request)
    {

        try {
            $result = Corpse::with('grave')
                ->where('name', 'like', '%' . $request->input('name') . '%')
                ->firstOrFail();

            $response = [
                'status' => 'success',
                'data' => $result,
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'data' => null,
            ];
        }

        return response()->json($response);
    }
}
