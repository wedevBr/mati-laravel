<?php
namespace WeDevBr\Mati;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use LogicException;

/**
 * Mati API wrapper class
 *
 * @author Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
 */
class Mati
{
    protected $client_id = null;
    protected $client_secret = null;
    protected string $access_token;

    /**
     * Mati class constructor
     *
     * @param string|null $client_id
     * @param string|null $client_secret
     */
    public function __construct(string $client_id = null, string $client_secret = null)
    {
        $this->resolveClientId($client_id);
        $this->resolveClientSecret($client_secret);

        if ($this->client_id && $this->client_secret) {
            $this->authorize();
        }
    }

    /**
     * Set Client ID for authorization
     *
     * @param string $client_id
     * @return self
     */
    public function setClientId(string $client_id)
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     * Set Client Secret for authorization
     *
     * @param string $client_secret
     * @return self
     */
    public function setClientSecret(string $client_secret)
    {
        $this->client_secret = $client_secret;

        return $this;
    }

    /**
     * Set API access token
     *
     * Good to use with caching for JWT token
     *
     * @param string $access_token
     * @return self
     */
    public function setAccessToken(string $access_token)
    {
        $this->access_token = $access_token;

        return $this;
    }

    /**
     * Perform HTTP to get an access token
     *
     * @throws RequestException
     * @return array
     */
    public function requestAccessToken()
    {
        return Http::withBasicAuth($this->client_id, $this->client_secret)
            ->asForm()
            ->post($this->getAuthURL(), ['grant_type' => 'client_credentials'])
            ->throw()
            ->json();
    }

    /**
     * Authorize with Mati's API credentials
     *
     * @param string|null $client_id
     * @param string|null $client_secret
     * @return self
     */
    public function authorize(string $client_id = null, string $client_secret = null)
    {
        if ($client_id) {
            $this->setClientId($client_id);
        }

        if ($client_secret) {
            $this->setClientSecret($client_secret);
        }

        if (!($this->client_id && $this->client_secret)) {
            throw new LogicException('No client ID and secret were given to authorize Mati');
        }

        $response = $this->requestAccessToken();

        $this->setAccessToken($response['access_token']);

        return $this;
    }

    /**
     * Alias for authorize()
     *
     * @see authorize()
     */
    public function authorise(...$args)
    {
        return $this->authorize(...$args);
    }

    /**
     * Resolve value for Client ID in the constructor
     *
     * @param string|null $client_id
     * @return void
     */
    protected function resolveClientId($client_id)
    {
        if ($client_id) {
            $this->setClientId($client_id);
        } else {
            $config_client_id = config('mati')['client_id'];
            if ($config_client_id) {
                $this->setClientId($config_client_id);
            }
        }
    }

    /**
     * Resolve value for Client Secret in the constructor
     *
     * @param string|null $client_secret
     * @return void
     */
    protected function resolveClientSecret($client_secret)
    {
        if ($client_secret) {
            $this->setClientSecret($client_secret);
        } else {
            $config_client_secret = config('mati')['client_secret'];
            if ($config_client_secret) {
                $this->setClientSecret($config_client_secret);
            }
        }
    }

    /**
     * Get auth API URL
     *
     * @return string
     */
    protected function getAuthURL()
    {
        return config('mati')['auth_url'];
    }
}