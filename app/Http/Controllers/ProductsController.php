<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsPostRequest;
use App\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::where('api_token', '=', $request['api_token'])->first();
        if ($user != null) {
            $products = Products::all();
            return response()->json(['status' => 'ok', 'data' => $products, 200]);
        }
        return response()->json(['errors' => array(['code' => 401,
            'message' => 'Usuario no autorizado.'])], 401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductsPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsPostRequest $request)
    {
        $user = User::where('api_token', '=', $request['api_token'])->first();
        if ($user != null) {
            $product = Products::create($request->all());
            return response()->json(['status' => 'ok', 'data' => $product, 200]);
        }
        return response()->json(['errors' => array(['code' => 401,
            'message' => 'Usuario no autorizado.'])], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('api_token', '=', $request['api_token'])->first();
        if ($user != null) {
            $product = Products::find($id);
            if (!$product) {
                return response()->json(['errors' => array(['code' => 404,
                    'message' => 'No se encuentra ese Producto.'])], 404);
            }
            return response()->json(['status' => 'ok', 'data' => $product, 200]);
        }
        return response()->json(['errors' => array(['code' => 401,
            'message' => 'Usuario no autorizado.'])], 401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductsPostRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsPostRequest $request, $id)
    {
        $user = User::where('api_token', '=', $request['api_token'])->first();
        if ($user != null) {
            $product = Products::find($id);
            if (!$product) {
                return response()->json(['errors' => array(['code' => 404,
                    'message' => 'No se encuentra ese Producto.'])], 404);
            }
            $product->fill($request->all());
            $product->save();
            return response()->json(['status' => 'ok', 'data' => $product, 200]);
        }
        return response()->json(['errors' => array(['code' => 401,
            'message' => 'Usuario no autorizado.'])], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::where('api_token', '=', $request['api_token'])->first();
        if ($user != null) {
            $product = Products::find($id);
            if (!$product) {
                return response()->json(['errors' => array(['code' => 404,
                    'message' => 'No se encuentra ese Producto.'])], 404);
            }
            Products::destroy($id);
            return response()->json(['status' => 'ok', 'data' => $product, 204]);

        }
        return response()->json(['errors' => array(['code' => 401,
            'message' => 'Usuario no autorizado.'])], 401);
    }
}
