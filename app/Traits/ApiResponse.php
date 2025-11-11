<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{

    protected  function successResponse(string $message, $data = null, int $code = 200): JsonResponse
    {

        return response()->json(
            [
                'success' => true,
                'message' => $message,
                "data" => $data,

            ],
            $code
        );
    }
    protected function errorResponse(
        string $message = 'Erreur serveur',
        int $code = 500,
        $errors = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
    protected function  paginatedResponse($paginator, string $message = 'Liste paginée récupérée avec succès'): JsonResponse
    {
        $paginatorArray = $paginator->toArray();

        $metadonne = [
            'date_creation' => now()->toIso8601String(),
            'version' => 1
        ];

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginatorArray['data'],
            "metadonnees" => $metadonne,
            'pagination' => [
                'current_page' => $paginatorArray['current_page'],
                'per_page' => $paginatorArray['per_page'],
                'total' => $paginatorArray['total'],
                'last_page' => $paginatorArray['last_page'],
                'from' => $paginatorArray['from'],
                'to' => $paginatorArray['to']
            ],
            'links' => [
                'first' => $paginatorArray['first_page_url'],
                'last' => $paginatorArray['last_page_url'],
                'prev' => $paginatorArray['prev_page_url'],
                'next' => $paginatorArray['next_page_url']
            ]
        ], 200);
    }
}
