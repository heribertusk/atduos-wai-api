<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        $filters = $request->validate([
            'name' => 'nullable|alpha'
        ]);

        $query = DB::table('reg_provinces')->when($filters['name'] ?? null, function ($q, $search) {
            $q->where('name', 'like', '%'.$search.'%');
        });

        return new ApiSuccessResponse($query->get(), ['rows_count' => $query->count()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
