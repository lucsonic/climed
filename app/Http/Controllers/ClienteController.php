<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClienteCollection;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private $clienteService;

    public function __construct()
    {
        $this->clienteService = new ClienteService();
    }

    public function listarClientes(Request $request)
    {
        return $this->clienteService->listarClientes($request);
    }

    public function cadastrarCliente(Request $request)
    {
        return $this->clienteService->cadastrarCliente($request);
    }

    public function excluirCliente($codCliente)
    {
        return $this->clienteService->excluirCliente($codCliente);
    }

    public function alterarCliente($codCliente, Request $request)
    {
        return $this->clienteService->alterarCliente($codCliente, $request);
    }

    public function ativarCliente($codCliente)
    {
        return $this->clienteService->ativarCliente($codCliente);
    }

    public function inativarCliente($codCliente)
    {
        return $this->clienteService->inativarCliente($codCliente);
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
