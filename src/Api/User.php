<?php

namespace CLDT\Clerk\Api;

use CLDT\Clerk\Helpers\ClerkApiResponse;

/**
 * Users API
 *
 * @see https://clerk.com/docs/reference/backend-api/tag/users
 */
class User extends BaseApi
{
    /**
     * List all Users
     *
     * @param array $parameters List of parameters
     *
     * @return ClerkApiResponse
     */
    public function list(array $parameters = []): ClerkApiResponse
    {
        $response = $this->client
            ->get('users', $parameters);

        return new ClerkApiResponse($response->getStatusCode(), $response->json());
    }

    /**
     * Get a User
     *
     * @param int $id User ID
     *
     * @return ClerkApiResponse
     */
    public function getOne(int $id): ClerkApiResponse
    {
        $response = $this->client
            ->get('users/' . $id);

        return new ClerkApiResponse($response->getStatusCode(), $response->json());
    }
}
