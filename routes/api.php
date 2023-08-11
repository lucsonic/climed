<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\SelectBoxController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('refresh', [LoginController::class, 'refresh']);
    Route::post('me', [LoginController::class, 'me']);
    Route::get('params', [LoginService::class, 'params'])->name('params');
});

Route::group(['middleware' => ['jwt']], function () {
    Route::prefix('perfil')->group(function () {
        Route::get('/listar', [PerfilController::class, 'listarPerfis']);
        Route::post('/cadastrar', [PerfilController::class, 'cadastrarPerfil']);
        Route::put('/{codPerfil}/excluir', [PerfilController::class, 'excluirPerfil']);
        Route::post('/{codPerfil}/alterar', [PerfilController::class, 'alterarPerfil']);
        Route::put('/{codPerfil}/inativar', [PerfilController::class, 'inativarPerfil']);
        Route::put('/{codPerfil}/ativar', [PerfilController::class, 'ativarPerfil']);
    });

    Route::prefix('usuario')->group(function () {
        Route::get('/listar', [UsuarioController::class, 'listarUsuarios']);
        Route::post('/cadastrar', [UsuarioController::class, 'cadastrarUsuario']);
        Route::put('/{codUsuario}/exlcuir', [UsuarioController::class, 'excluirUsuario']);
        Route::post('/alterar', [UsuarioController::class, 'alterarUsuario']);
        Route::put('/{codUsuario}/inativar', [UsuarioController::class, 'inativarUsuario']);
        Route::put('/{codUsuario}/ativar', [UsuarioController::class, 'ativarUsuario']);
        Route::get('/editar/{id}', [UsuarioController::class, 'editarUsuario']);
    });

    Route::prefix('permissao')->group(function () {
        Route::get('/listar', [PermissaoController::class, 'listarPermissoes']);
        Route::post('/cadastrar', [PermissaoController::class, 'cadastrarPermissao']);
        Route::put('/{codPermissao}/exlcuir', [PermissaoController::class, 'excluirPermissao']);
        Route::post('/{codPermissao}/alterar', [PermissaoController::class, 'alterarPermissao']);
    });

    Route::prefix('funcao')->group(function () {
        Route::get('/listar', [FuncaoController::class, 'listarFuncoes']);
        Route::post('/cadastrar', [FuncaoController::class, 'cadastrarFuncao']);
        Route::put('/{codFuncao}/exlcuir', [FuncaoController::class, 'excluirFuncao']);
        Route::post('/{codFuncao}/alterar', [FuncaoController::class, 'alterarFuncao']);
        Route::put('/{codFuncao}/inativar', [FuncaoController::class, 'inativarFuncao']);
        Route::put('/{codFuncao}/ativar', [FuncaoController::class, 'ativarFuncao']);
    });

    Route::prefix('especialidade')->group(function () {
        Route::get('/listar', [EspecialidadeController::class, 'listarEspecialidades']);
        Route::post('/cadastrar', [EspecialidadeController::class, 'cadastrarEspecialidade']);
        Route::put('/{codEspecialidade}/exlcuir', [EspecialidadeController::class, 'excluirEspecialidade']);
        Route::post('/{codEspecialidade}/alterar', [EspecialidadeController::class, 'alterarEspecialidade']);
        Route::put('/{codEspecialidade}/inativar', [EspecialidadeController::class, 'inativarEspecialidade']);
        Route::put('/{codEspecialidade}/ativar', [EspecialidadeController::class, 'ativarEspecialidade']);
    });

    Route::prefix('departamento')->group(function () {
        Route::get('/listar', [DepartamentoController::class, 'listarDepartamentos']);
        Route::post('/cadastrar', [DepartamentoController::class, 'cadastrarDepartamento']);
        Route::put('/{codDepartamento}/exlcuir', [DepartamentoController::class, 'excluirDepartamento']);
        Route::post('/{codDepartamento}/alterar', [DepartamentoController::class, 'alterarDepartamento']);
        Route::put('/{codDepartamento}/inativar', [DepartamentoController::class, 'inativarDepartamento']);
        Route::put('/{codDepartamento}/ativar', [DepartamentoController::class, 'ativarDepartamento']);
    });

    Route::prefix('cliente')->group(function () {
        Route::get('/listar', [ClienteController::class, 'listarClientes']);
        Route::post('/cadastrar', [ClienteController::class, 'cadastrarCliente']);
        Route::put('/{codCliente}/exlcuir', [ClienteController::class, 'excluirCliente']);
        Route::post('/{codCliente}/alterar', [ClienteController::class, 'alterarCliente']);
        Route::put('/{codCliente}/inativar', [ClienteController::class, 'inativarCliente']);
        Route::put('/{codCliente}/ativar', [ClienteController::class, 'ativarCliente']);
    });

    Route::prefix('funcionario')->group(function () {
        Route::get('/listar', [FuncionarioController::class, 'listarFuncionarios']);
        Route::post('/cadastrar', [FuncionarioController::class, 'cadastrarFuncionario']);
        Route::put('/{codFuncionario}/exlcuir', [FuncionarioController::class, 'excluirFuncionario']);
        Route::post('/{codFuncionario}/alterar', [FuncionarioController::class, 'alterarFuncionario']);
        Route::put('/{codFuncionario}/inativar', [FuncionarioController::class, 'inativarFuncionario']);
        Route::put('/{codFuncionario}/ativar', [FuncionarioController::class, 'ativarFuncionario']);
    });

    Route::prefix('listar')->group(function () {
        Route::get('/perfis', [SelectBoxController::class, 'listarPerfis']);
    });
});
