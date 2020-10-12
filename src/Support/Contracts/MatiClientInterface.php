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
    public function withToken(string $access_token): MatiClientInterface;

    /**
     * Get an access token from the OAuth service
     *
     * @param string $client_id
     * @param string $client_secret
     * @return Response
     */
    public function getAccessToken(string $client_id, string $client_secret): Response;

    /**
     * Create a new verification process
     *
     * @param array|null $metadata Key/Value pair of data to identify the user
     * @param string|null $flowId
     * @param string|null $user_ip
     * @param null $user_agent
     * @return Response
     */
    public function createVerification(
        $metadata = null,
        $flowId = null,
        $user_ip = null,
        $user_agent = null
    ): Response;

    /**
     * Send an input for a document, selfie or other file required during a process
     *
     * @param string $identity_id
     * @param IdentityInputInterface[]|Collection $inputs
     * @return Response
     */
    public function sendInput(string $identity_id, $inputs): Response;

    /**
     * Retrieve info about a verification process
     *
     * @param string $resource_url URL received by webhook
     * @return Response
     */
    public function retrieveResourceDataFromUrl(string $resource_url);

    /**
     * Retrieve info about a verification process
     *
     * @param string $verification_id
     * @return Response
     */
    public function retrieveResourceDataByVerificationId(string $verification_id);

    /**
     * Download the file sent by the user during the verification process
     *
     * @param string $media_url
     * @return Response
     */
    public function downloadVerificationMedia(string $media_url);
}
