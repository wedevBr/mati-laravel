<?php

namespace WeDevBr\Mati\Support\Contracts;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

interface MatiClientInterface
{
    public function __construct(string $access_token = null);

    /**
     * Set an access token to be used by the requests
     *
     * @param string $access_token
     * @return self
     */
    public function withToken(string $access_token): self;

    /**
     * Get an access token from the OAuth service
     *
     * @param string $client_id
     * @param string $client_user
     * @return Response
     */
    public function getAccessToken(string $client_id, string $client_secret): Response;

    /**
     * Create a new identity for a user that will be verified
     *
     * @param array|null $metadata Key/Value pair of data to identify the user
     * @param string|null $flowId
     * @param string|null $user_ip
     * @return Response
     */
    public function createIdentity($metadata = null, $flowId = null, $user_ip = null): Response;

    /**
     * Send an input for a document, selfie or other file required during a process
     *
     * @param string $identity_id
     * @param IdentityInputInterface[]|Collection $inputs
     * @return Response
     */
    public function sendInput(string $identity_id, $inputs): Response;
}
