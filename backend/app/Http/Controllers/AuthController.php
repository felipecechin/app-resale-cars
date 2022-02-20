<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class AuthController extends Controller {

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
        $messages = [
            'required' => 'O campo :attribute é obrigatório',
            'email.email' => 'O e-mail deve ser válido',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres',
        ];

        $validator = Validator::make($request->toArray(), $rules, $messages, ['email' => 'e-mail', 'password' => 'senha']);


        if ($validator->fails()) {
            $formatMessages = formatMessages($validator->messages()->toArray());
            return response()->json(['message' => $formatMessages], 400);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['message' => 'E-mail e/ou senha inválidos'], 401);
        }
        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $rules = [
            'name' => 'required|between:2,100',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|confirmed|min:6',
        ];
        $messages = [
            'required' => 'O campo :attribute é obrigatório',
            'name.between' => 'O campo nome deve ter entre 2 a 100 caracteres',
            'email.email' => 'O e-mail deve ser válido',
            'email.max' => 'O campo e-mail deve ter no máximo 100 caracteres',
            'email.unique' => 'Já existe um usuário com esse e-mail',
            'password.confirmed' => 'As senhas devem ser iguais',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres',
        ];

        $validator = Validator::make($request->toArray(), $rules, $messages, ['name' => 'nome', 'email' => 'e-mail', 'password' => 'senha']);


        if ($validator->fails()) {
            $formatMessages = formatMessages($validator->messages()->toArray());
            return response()->json(['message' => $formatMessages], 400);
        }


        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'Usuário criado com sucesso',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Usuário deslogado com sucesso']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user()
        ]);
    }
}
