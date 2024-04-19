<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        // $client = Client::find($id);
        return $client;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Código 422 para "Unprocessable Entity"
        }

        try {
            $client = new Client;
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->save();

            // Operación exitosa
            return response()->json([
                'status' => 'success',
                'message' => 'Cliente creado exitosamente',
                'data' => $client
            ]);
        } catch (\Exception $e) {
            // Error en la operación
            return response()->json([
                'status' => 'error',
                'message' => 'Ha ocurrido un error al crear el cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Código 422 para "Unprocessable Entity"
        }

        try {
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->update();

            // Operación exitosa
            return response()->json([
                'status' => 'success',
                'message' => 'Cliente actualizado exitosamente',
                'data' => $client
            ]);
        } catch (\Exception $e) {
            // Error en la operación
            return response()->json([
                'status' => 'error',
                'message' => 'Ha ocurrido un error al actualizar el cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $client = Client::find($id);

        if (is_null($client)) {
            return response()->json(['error' => 'Id del cliente no encontrado'], 404);
        }

        $client->delete();
        return response()->noContent();

    }
}
