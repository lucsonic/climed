<?php

namespace App\Http\Controllers;

use App\Repositories\SelectBoxRepository;

class SelectBoxController extends Controller
{
    private $repository;

    public function __construct()
    {
        $this->repository = new SelectBoxRepository();
    }

    public function listarPerfis()
    {
        return $this->repository->perfis();
    }
}
