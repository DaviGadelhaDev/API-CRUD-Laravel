<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() : JsonResponse
    {
        $users = User::orderBy('id', 'DESC')->paginate(5);
        return response()->json([
            'status' => true,
            'users' => $users
        ], 200); 
    }

    public function show(User $user)
    {   
        return response()->json([
            'status' => true,
            'user' => $user
        ], 200); 
    }

    public function store(UserRequest $request) : JsonResponse
    {
        //Iniciando a transação
        DB::beginTransaction();
        try
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            //Concluindo o registro
            DB::commit();
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário cadastrado com sucesso"
            ], 201);
        }
        catch(Exception $e)
        {
            //Operação não é concluída com êxito (utilizar o DB::rollback() para cancelar a operação)
            DB::rollBack();
            return response()->json([
               'status' => false,
               'message' => "Usuário não cadastrado"
            ], 400);
        }
    }

    public function update(UserRequest $request, User $user) : JsonResponse
    {
        //Iniciando a transação
        DB::beginTransaction();
        try
        {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            //Concluindo o registro
            DB::commit();
            return response()->json([
               'status' => true,
                'user' => $user,
               'message' => "Usuário atualizado com sucesso"
            ], 200);
        }
        catch(Exception $e)
        {
            //Operação não é concluída com êxito (utilizar o DB::rollback() para cancelar a operação)
            DB::rollBack();
            return response()->json([
               'status' => false,
               'message' => "Usuário não atualizado"
            ], 400);
        }
    }

    public function destroy(User $user) : JsonResponse
    {
        try
        {
            $user->delete();

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário apagado com sucesso"
             ], 200);
        }
        catch(Exception $e)
        {
             //Operação não é concluída com êxito (utilizar o DB::rollback() para cancelar a operação)
             DB::rollBack();
             return response()->json([
                'status' => false,
                'message' => "Usuário não apagado"
             ], 400);
        }
    }
}   
