<?php

namespace App\Http\Controllers\Promo;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Http\Requests\PromoRequest;
use App\Services\PromoService;
class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $promo = Promo::paginate(5);

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'user' => $promo
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
    public function store(PromoRequest $request, PromoService $promoService)
    {
        try {
            $request = $request->validated();

            $promo = $promoService->store($request);

            return response()->json([
                'status' => true,
                'message' => 'Promo Created Successfully',
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
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function show(Promo $promo)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'user' => $promo
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
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function edit(Promo $promo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function update(PromoRequest $request, Promo $promo, PromoService $promoService)
    {
        try {
            $promo = $promoService->update($promo, $request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Promo Updated Successfully',
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
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promo $promo, PromoService $promoService)
    {
        try {

            if(!$promo){
                return response()->json([
                    'status' => true,
                    'message' => 'Catalog not found!',
                ], Response::HTTP_NOT_FOUND);
            }

            $promoService->destroy($promo);

            return response()->json([
                'status' => true,
                'message' => 'Promo Deleted Successfully',
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
