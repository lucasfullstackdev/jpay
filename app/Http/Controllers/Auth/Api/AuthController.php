<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

  public function __construct(
    // private UserService $userService
  )
  {
  }

  public function login(Login $request)
  {
    $credentials = $request->only('email', 'password');

    // Validando as credenciais
    if (!auth()->attempt($credentials)) {
      abort(Response::HTTP_UNAUTHORIZED, 'Credentials');
    }

    $user = auth()->user();

    // Devemos puxar os minutos das configuracoes
    $token = $user->createToken(
      $request->device,
      ['*'],
      Carbon::now()->addMinutes(config('sanctum.expiration'))
    );

    return response()->json([
      'data' => [
        'token' => $token->plainTextToken
      ]
    ]);
  }

  /** Desconectando do dispositivo atual */
  public function logout(Request $request)
  {
    $request->user()->currentAccessToken()->delete();

    return response()->json([
      'success' => true,
      'message' => 'Dispositivo desconectado'
    ]);
  }

  /**
   * Desconectando de todos os dispositivos
   */
  public function logoutAll(Request $request)
  {
    $request->user()->tokens()->delete();

    return response()->json([
      'success' => true,
      'message' => 'Todos os Dispositivos foram desconectados'
    ]);
  }

  /**
   * Trazendos algumas informações importantes do usuário autenticado
   */
  public function me(Request $request)
  {
    $user = $request->user();
    $currentToken = $user->currentAccessToken();
    $tokens = $user->tokens()->where('token', '!=', $user->currentAccessToken()->token);

    return response()->json([
      'data' => [
        'name' => $user->name,
        'email' => $user->email,
        'devices' => [
          'current' => $currentToken->name,
          'others' => $tokens->pluck('name')
        ]
      ]
    ]);
  }
}
