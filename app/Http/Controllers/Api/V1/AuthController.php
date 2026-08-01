<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Authentication', description: 'User authentication endpoints')]
class AuthController extends Controller
{
    use ApiResponder;

    public function __construct(protected AuthService $authService)
    {
    }

    #[OA\Post(
        path: '/api/v1/register',
        summary: 'Register a new user',
        description: 'Create a new user account and return an authentication token.',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password', 'password_confirmation'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'secret123'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'secret123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'User registered successfully'),
            new OA\Response(response: 422, description: 'Validation failed'),
        ]
    )]
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->registerUser($request->validated());

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->responseWithToken(
            $token,
            new UserResource($user),
            'api.user_registered_successfully',
            201
        );
    }

    #[OA\Post(
        path: '/api/v1/login',
        summary: 'Login user',
        description: 'Authenticate a user and return an access token.',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'secret123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Login successful'),
            new OA\Response(response: 401, description: 'Invalid credentials'),
        ]
    )]
    public function login(LoginRequest $request)
    {
        $user = $this->authService->authenticate($request->email, $request->password);

        if (! $user) {
            return $this->unauthorized('api.invalid_credentials');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->responseWithToken(
            $token,
            new UserResource($user),
            'api.login_successful',
            200
        );
    }

    #[OA\Post(
        path: '/api/v1/logout',
        summary: 'Logout user',
        description: 'Invalidate the currently authenticated access token.',
        tags: ['Authentication'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'User logged out successfully'),
        ]
    )]
    public function logout(Request $request)
    {
        $this->authService->logoutUser($request->user());

        return $this->success(null, 'api.logged_out_successfully');
    }
}
