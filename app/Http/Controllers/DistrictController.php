<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        $filters = $request->validate([
            'name' => 'nullable|alpha|min:3|max:50|required_without:regency_id',
            'regency_id' => 'nullable|numeric|required_without:name',
        ]);

        $query = DB::table('reg_districts')->when($filters['name'] ?? null, function ($q, $search) {
            $q->where('name', 'like', '%'.$search.'%');
        })->when($filters['regency_id'] ?? null, function ($q, $search) {
            $q->where('regency_id', $search);
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
        try {
            $record = DB::table('reg_districts')->where('id', $id)->first();

            if (! $record) {
                throw new ModelNotFoundException('No record found for the given criteria.');
            }

            return new ApiSuccessResponse($record, ['messages' => 'Data found.']);
        } catch (ModelNotFoundException $mex) {
            return new ApiErrorResponse(
                $mex,
                $mex->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
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
