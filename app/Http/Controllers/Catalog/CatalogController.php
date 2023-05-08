<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Http\Requests\CatalogRequest;
use App\Services\CatalogService;
class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $catalog = Catalog::paginate(5);

            return response()->json([
                'status' => true,
                'message' => 'User Updated Successfully',
                'user' => $catalog
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogRequest $request, CatalogService $catalogService)
    {
        try {
            $request = $request->validated();

            $catalog = $catalogService->store($request);

            return response()->json([
                'status' => true,
                'message' => 'Catalog Created Successfully',
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function show(Catalog $catalog)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'user' => $catalog
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalog $catalog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function update(CatalogRequest $request, Catalog $catalog, CatalogService $catalogService)
    {
        try {
            $catalog = $catalogService->update($catalog, $request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Catalog Updated Successfully',
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalog $catalog, CatalogService $catalogService)
    {
        try {
            if(!$catalog){
                return response()->json([
                    'status' => true,
                    'message' => 'Catalog not found!',
                ], Response::HTTP_NOT_FOUND);
            }

            $catalogService->destroy($catalog);

            return response()->json([
                'status' => true,
                'message' => 'Catalog Deleted Successfully',
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
