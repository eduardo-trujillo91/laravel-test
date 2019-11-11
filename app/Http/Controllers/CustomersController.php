<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Http\Requests\CustomersPostRequest;
use App\User;
use Illuminate\Http\Request;

class CustomersController extends Controller
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
            $customers = Customers::all();
            return response()->json(['status' => 'ok', 'data' => $customers, 200]);
        }
        return response()->json(['errors' => array(['code' => 401,
            'message' => 'Usuario no autorizado.'])], 401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CustomersPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomersPostRequest $request)
    {
        $user = User::where('api_token', '=', $request['api_token'])->first();
        if ($user != null) {
            $customer = Customers::create($request->all());
            return response()->json(['status' => 'ok', 'data' => $customer, 200]);
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
    public function show(Request $request, $id)
    {
        $user = User::where('api_token', '=', $request['api_token'])->first();
        if ($user != null) {
            $customer = Customers::find($id);
            if (!$customer) {
                return response()->json(['errors' => array(['code' => 404,
                    'message' => 'No se encuentra ese Cliente.'])], 404);
            }
            return response()->json(['status' => 'ok', 'data' => $customer, 200]);
        }
        return response()->json(['errors' => array(['code' => 401,
            'message' => 'Usuario no autorizado.'])], 401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CustomersPostRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomersPostRequest $request, $id)
    {
        $user = User::where('api_token', '=', $request['api_token'])->first();
        if ($user != null) {
            $customer = Customers::find($id);
            if (!$customer) {
                return response()->json(['errors' => array(['code' => 404,
                    'message' => 'No se encuentra ese Cliente.'])], 404);
            }
            $customer->fill($request->all());
            $customer->save();
            return response()->json(['status' => 'ok', 'data' => $customer, 200]);
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
            $customer = Customers::find($id);
            if (!$customer) {
                return response()->json(['errors' => array(['code' => 404,
                    'message' => 'No se encuentra ese Cliente.'])], 404);
            }
            $products = $customer->products()->first();
            if ($products != null) {
                return response()->json(['errors' => array(['code' => 409,
                    'message' => 'Productos asociados a este Cliente.'])], 409);
            }
            Customers::destroy($id);
            return response()->json(['status' => 'ok', 'data' => $customer, 204]);
        }
        return response()->json(['errors' => array(['code' => 401,
            'message' => 'Usuario no autorizado.'])], 401);
    }
}
