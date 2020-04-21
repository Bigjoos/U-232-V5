<?php

declare(strict_types = 1);

namespace U232V5;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use MatthiasMullie\Scrapbook\Adapters\Apc;
use MatthiasMullie\Scrapbook\Adapters\Collections\Utils\PrefixKeys;
use MatthiasMullie\Scrapbook\Adapters\Flysystem;
use MatthiasMullie\Scrapbook\Adapters\Memcached;
use MatthiasMullie\Scrapbook\Adapters\MemoryStore;
use MatthiasMullie\Scrapbook\Adapters\Redis;
use MatthiasMullie\Scrapbook\Buffered\BufferedStore;
use MatthiasMullie\Scrapbook\Buffered\TransactionalStore;
use MatthiasMullie\Scrapbook\Exception\UnbegunTransaction;
use MatthiasMullie\Scrapbook\KeyValueStore;

/**
 * Class Cache.
 */
class Cache extends TransactionalStore
{
    protected array $config;
    protected KeyValueStore $cache;

    public function __construct(array $config)
    {
        $this->config = $config;

        switch ($this->config['sitecache']['driver']) {
            case 'apcu':
                if (extension_loaded('apcu')) {
                    $this->cache = new Apc();
                } else {
                    die('<h1>Error</h1><p>php-apcu is not available</p>');
                }

                break;

            case 'memcached':
                if (extension_loaded('memcached')) {
                    $cache = new \Memcached();
                    if (!count($cache->getServerList())) {
                        if (!$this->config['memcached']['use_socket']) {
                            $cache->addServer($this->config['memcached']['host'], $this->config['memcached']['port']);
                        } else {
                            $cache->addServer($this->config['memcached']['socket'], 0);
                        }
                    }
                    $this->cache = new Memcached($cache);
                } else {
                    die('<h1>Error</h1><p>php-memcached is not available</p>');
                }

                break;

            case 'redis':
                if (extension_loaded('redis')) {
                    $cache = new \Redis();
                    if (!$this->config['redis']['use_socket']) {
                        $cache->connect($this->config['redis']['host'], $this->config['redis']['port']);
                    } else {
                        $cache->connect($this->config['redis']['socket']);
                    }
                    $cache->select($this->config['redis']['database']);
                    $this->cache = new Redis($cache);
                } else {
                    die('<h1>Error</h1><p>php-redis is not available</p>');
                }
                break;

            case 'memory':
                $this->cache = new MemoryStore();
                break;

            case 'file':
                $adapter = new Local($this->config['files']['path'], LOCK_EX);
                $filesystem = new Filesystem($adapter);
                $this->cache = new Flysystem($filesystem);
                break;

            default:
                die('Invalid Adaptor: ' . $this->config['sitecache']['driver'] . '<br>Valid choices: memory, file, apcu, memcached, redis, couchbase');
        }
        $this->cache = new PrefixKeys($this->cache, $this->config['sitecache']['prefix']);
        $this->cache = new BufferedStore($this->cache);
        $this->cache = new TransactionalStore($this->cache);

        parent::__construct($this->cache);
    }

    /**
     * @param $key
     * @param $set
     * @param int $ttl
     *
     * @throws UnbegunTransaction
     */
    public function update_row($key, $set, $ttl = 0)
    {
        $this->begin();
        $array = $this->get($key);
        if (!empty($array)) {
            $array = array_replace($array, $set);
            $this->set($key, $array, $ttl);
        }
        $this->commit();
    }

    /**
     * @return bool
     */
    public function flushDB()
    {
        if (file_exists($this->config['files']['path'] . 'CompiledContainer.php')) {
            unlink($this->config['files']['path'] . 'CompiledContainer.php');
        }
        if ($this->config['sitecache']['driver'] === 'redis') {
            $client = new \Redis();
            if (!$this->config['redis']['use_socket']) {
                $client->connect($this->config['redis']['host'], $this->config['redis']['port']);
            } else {
                $client->connect($this->config['redis']['socket']);
            }
            $client->select((int) $this->config['redis']['database']);

            return $client->flushDB();
        } else {
            return $this->flush();
        }
    }
}
