<?php

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('SuccessResponse')) {

    /**
     * Retorna o response de sucesso da aplicação
     *
     * @return $sucesso,
     * Response
     */
    function SuccessResponse($data = null)
    {
        $sucesso = [
            'sucesso' => [
                'message' => 'Query executada com sucesso!',
            ],
        ];

        if (!empty($data)) {
            $sucesso['data'] = $data;
        }

        return response()->json($sucesso, Response::HTTP_OK);
    }
}

if (!function_exists('ErrorResponse')) {

    /**
     * Retorna o response de erro com a exception da classe Oci8Exception, que não é identificado pelo Hadler padrão do Laravel
     *
     * @return $erro,
     * Response
     */
    function ErrorResponse($e)
    {
        $erro = [
            'error' => [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ],
        ];
        return response()->json($erro, 400);
    }
}

if (!function_exists('AlertResponse')) {

    /**
     * Retorna o response de alerta da aplicação
     *
     * @return $erro,
     * Response
     */
    function AlertResponse($msg, $code)
    {
        $erro = [
            'erro' => [
                'message' => $msg,
            ],
        ];
        return response()->json($erro, $code);
    }
}

if (!function_exists('removeMascara')) {
    function removeMascara($input)
    {
        return preg_replace('/[^0-9]/', '', $input);
    }

}

if (!function_exists('dateDB')) {
    function dateDB($data)
    {
        $dataFormat = null;
        if (isset($data) && $data) :
            $data  = Carbon::createFromFormat('d/m/Y', $data);
            $dataFormat  = $data->format('Y-m-d');
        endif;

        return $dataFormat;
    }
}
