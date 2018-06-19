<?php

namespace AppBundle\Service;

/**
 * Class OfferApi
 * @package AppBundle\Service
 */
class OfferApi
{
    /**
     * @var String
     */
    private $apiUrl;

    /**
     * OfferApi constructor.
     * @param string $apiUrl
     */
    public function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getList()
    {
        $restClient = new RestClient($this->apiUrl);
        return $restClient->callApi('/offers', 'GET');
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function getOne(int $id)
    {
        $restClient = new RestClient($this->apiUrl);
        return $restClient->callApi('/offers/'.$id, 'GET');
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function post(object $params)
    {
        $restClient = new RestClient($this->apiUrl);
        return $restClient->callApi('/offer', 'POST', ['form_params' => $params]);
    }

    /**
     * @param int $id
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function update(int $id, array $params)
    {
        $restClient = new RestClient($this->apiUrl);
        return $restClient->callApi('/offer/'.$id, 'PUT', ['body' => json_encode($params, true)]);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $restClient = new RestClient($this->apiUrl);
        return $restClient->callApi('/offer/'.$id, 'DELETE');
    }
}