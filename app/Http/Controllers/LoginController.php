<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\InfoUsuarioResource;
use App\Models\Auditoria;
use App\Models\Usuario;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    private $loginService;
    private $auditoriaModel;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
        $this->loginService = new LoginService();
        $this->auditoriaModel = new Auditoria();
    }

    public function login(Request $request)
    {
        $usuario = $this->loginService->login($request);

        if ($usuario) {
            if (password_verify($request->dsc_senha, $usuario->dsc_senha) && $usuario->flg_ativo === '1') {
                $userToken = JWTAuth::fromUser($usuario);
                $dadosAuditoria = $this->getLastAccess($usuario->{Usuario::COD_USUARIO});
                Auditoria::adicionar('Login', $usuario->{Usuario::COD_USUARIO}, 'O usuário ' . $request->dsc_email . ' entrou no sistema.');

                return response()->json([
                    'access_token' => $userToken,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::factory()->getTTL() * 60,
                    'usuario' => new InfoUsuarioResource(Usuario::find($usuario->{Usuario::COD_USUARIO})),
                    'ultimo_acesso' => count($dadosAuditoria) > 0 ? date('d/m/Y H:i:s', strtotime($dadosAuditoria[0]->dat_cadastro)) : 'Sem histórico',
                    'nome_empresa' => 'Clínica Bonifácio',
                    'modulo' => 'default'
                ]);
            } 
            
            if (!password_verify($request->dsc_senha, $usuario->dsc_senha)) {
                return response()->json(['error' => 'Senha incorreta!'], 401);
            }

            if ($usuario->flg_ativo === '0') {
                return response()->json(['error' => 'Usuário desativado!'], 401);
            }
        }

        return response()->json(['error' => 'Usuário não encontrado'], 404);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    private function getLastAccess($codUsuario)
    {
        $auditoria = $this->auditoriaModel->query()
            ->select(Auditoria::TABLE . '.' . '*')
            ->where(Auditoria::TABLE . '.' . Auditoria::COD_USUARIO, '=', $codUsuario)
            ->where(Auditoria::TABLE . '.' . Auditoria::DSC_TITULO, '=', 'Login')
            ->orderBy(Auditoria::TABLE . '.' . Auditoria::DAT_CADASTRO, 'DESC')
            ->limit(1)
            ->get();

        return $auditoria;
    }

    protected function makeResource($query)
    {
        return null;
    }

    protected function makeCollection($query)
    {
        return null;
    }
}
