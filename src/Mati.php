<?php

namespace WeDevBr\Mati;

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

}
