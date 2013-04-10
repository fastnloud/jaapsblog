<?php

namespace Blog\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\Cache\StorageFactory;

class Amazon extends ServiceManager
{

    /**
     * @var \SoapClient
     */
    protected $client;

    /**
     * @var array|\Zend\Config\Config
     */
    protected $config;

    /**
     * @var string
     */
    protected $operation;

    /**
     * @var time
     */
    protected $timestamp;

    /**
     * @var \Zend\Cache\Storage\StorageInterface
     */
    protected $cache;

    /**
     * @var int
     */
    //protected $cacheTime = 1;
    protected $cacheTime = 43200; // 12 hours.

    /**
     * Initialize SoapClient to communicate
     * with Amazon service.
     */
    public function __construct()
    {
        // Load config file.
        // TODO: Autoload config.
        $config = new \Zend\Config\Factory();
        $this->config = $config->fromFile(__DIR__.'/../../../../../config/autoload/local.php');

        // Initialize caching.
        $this->cache = StorageFactory::factory(array('adapter' => array('name' => 'filesystem')));
        $this->cache->setOptions(array(
            'cache_dir'       => 'data/cache/amazon',
            'file_permission' => '666',
            'dir_permission'  => '777'
        ));
    }

    /**
     * Generate signature.
     *
     * @return string
     */
    protected function getSignature()
    {
        return base64_encode(
            hash_hmac(
                'sha256',
                $this->operation.$this->timestamp,
                $this->config['amazon']['secretAccessKey'],
                true
            )
        );
    }

    /**
     * Generate signed headers.
     */
    protected function setSignedHeaders()
    {
        $headers[] = new \SoapHeader('http://security.amazonaws.com/doc/2007-01-01/', 'AWSAccessKeyId', $this->config['amazon']['accessKeyId']);
        $headers[] = new \SoapHeader('http://security.amazonaws.com/doc/2007-01-01/', 'Timestamp', $this->timestamp);
        $headers[] = new \SoapHeader('http://security.amazonaws.com/doc/2007-01-01/', 'Signature', $this->getSignature());

        $this->client->__setSoapHeaders($headers);
    }

    /**
     * Merge give options with the option defaults needed
     * to make signed calls.
     *
     * @param array $options
     *
     * @return array
     */
    protected function mergeOptions(array $options = array())
    {
        $mergedOptions = array(
            'Operation'         => $this->operation,
            'AssociateTag'      => $this->config['amazon']['associateTag'],
            'Request'           => $options
        );

        return array($mergedOptions);
    }

    /**
     * Preform operation request. Response will be cached for
     * $this->cacheTime seconds.
     *
     * @param $operation
     * @param array $options
     *
     * @return bool|mixed
     */
    protected function request($operation, array $options = array(), $cacheId)
    {
        // This will determine if we use cache or not.
        $refresh = false; // Default is cache.

        if (!$this->cache->hasItem($cacheId)) {
            $refresh = true;
        } else {
            $metaData = $this->cache->getMetadata($cacheId);
            if ($metaData['mtime']+$this->cacheTime < time()) {
                $refresh = true;;
            } else {
                $response = unserialize($this->cache->getItem($cacheId));
            }
        }

        // Make a new call.
        if (true == $refresh) {
            try {
                // Initialize client.
                $this->client = new \SoapClient('http://webservices.amazon.com/AWSECommerceService/AWSECommerceService.wsdl');

                // Set operation and timestamp.
                $this->operation = $operation;
                $this->timestamp = gmdate('Y-m-d\TH:i:s\Z');

                // Set signed headers (with operation, timestamp and signature).
                $this->setSignedHeaders();

                // Response.
                $response = $this->client->__soapCall($operation, $this->mergeOptions($options));

                // Validate the response.
                if (!$response->Items->Request->IsValid || isset($response->Items->Request->Errors)) {
                    return false;
                }

                // Remove cached item.
                if ($this->cache->hasItem($cacheId)) {
                    $this->cache->removeItem($cacheId);
                }

                // Cache if valid and no errors occurred.
                $this->cache->addItem($cacheId, serialize($response)); // Cache response.
            } catch (\SoapFault $e) {
                return false;
            }
        }

        return $response;
    }

    /**
     * Amazon itemSearch method.
     *
     * @param array $options
     * @return mixed
     */
    public function itemSearch(array $options = array(), $cacheId)
    {
        return $this->request('ItemSearch', $options, $cacheId);
    }

    /**
     * Amazon itemLookup method.
     *
     * @param array $options
     * @return mixed
     */
    public function itemLookup(array $options = array(), $cacheId)
    {
        return $this->request('ItemLookup', $options, $cacheId);
    }

}