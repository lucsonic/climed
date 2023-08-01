<?php

namespace App\Services;

use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteService
{
    private $clienteRepository;

    public function __construct()
    {
        $this->clienteRepository = new ClienteRepository();
    }

    public function listarClientes(Request $request)
    {
        return $this->clienteRepository->listarClientes($request);
    }

    public function cadastrarCliente(Request $request)
    {
        return $this->clienteRepository->cadastrarCliente($request);
    }

    public function excluirCliente($codCliente)
    {
        return $this->clienteRepository->excluirCliente($codCliente);
    }

    public function alterarCliente($codCliente, Request $request)
    {
        return $this->clienteRepository->alterarCliente($codCliente, $request);
    }

    public function ativarCliente($codCliente)
    {
        return $this->clienteRepository->ativarCliente($codCliente);
    }

    public function inativarCliente($codCliente)
    {
        return $this->clienteRepository->inativarCliente($codCliente);
    }
}
