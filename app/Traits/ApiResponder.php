<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponder
{
    /**
     * Build a standardized JSON response.
     */
    private function respond(
        bool $success,
        string $message,
        int $statusCode,
        mixed $data = null,
        array $extra = []
    ): JsonResponse {
        $response = [
            'success' => $success,
            'status' => $statusCode,
            'message' => __($message),
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json(
            array_merge($response, $extra),
            $statusCode
        );
    }

    /**
     * Successful response.
     */
    protected function success(
        mixed $data = null,
        string $message = 'api.success',
        int $statusCode = 200,
        array $extra = []
    ): JsonResponse {
        return $this->respond(true, $message, $statusCode, $data, $extra);
    }

    /**
     * Resource created response.
     */
    protected function created(
        mixed $data = null,
        string $message = 'api.created_successfully'
    ): JsonResponse {
        return $this->success($data, $message, 201);
    }

    /**
     * Error response.
     */
    protected function error(
        string $message = 'api.error',
        int $statusCode = 400,
        mixed $data = null,
        array $extra = []
    ): JsonResponse {
        return $this->respond(false, $message, $statusCode, $data, $extra);
    }

    protected function unauthorized(
        string $message = 'api.unauthorized'
    ): JsonResponse {
        return $this->error($message, 401);
    }

    protected function forbidden(
        string $message = 'api.forbidden'
    ): JsonResponse {
        return $this->error($message, 403);
    }

    protected function notFound(
        string $message = 'api.not_found'
    ): JsonResponse {
        return $this->error($message, 404);
    }

    protected function conflict(
        string $message = 'api.conflict'
    ): JsonResponse {
        return $this->error($message, 409);
    }

    protected function validationError(
        mixed $errors = null,
        string $message = 'api.validation_failed'
    ): JsonResponse {
        return $this->error($message, 422, $errors);
    }

    protected function tooManyRequests(
        string $message = 'api.too_many_requests'
    ): JsonResponse {
        return $this->error($message, 429);
    }

    protected function serverError(
        string $message = 'api.internal_server_error'
    ): JsonResponse {
        return $this->error($message, 500);
    }

    /**
     * Success response with authentication token.
     */
    protected function responseWithToken(
        string $token,
        mixed $data = null,
        string $message = 'api.login_successful',
        int $statusCode = 200
    ): JsonResponse {
        return $this->success(
            data: $data,
            message: $message,
            statusCode: $statusCode,
            extra: [
                'token' => $token,
            ]
        );
    }
}
