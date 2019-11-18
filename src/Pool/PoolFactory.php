<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Hyperf\JsonRpc\Pool;

use Hyperf\Di\Container;
use Hyperf\Di\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

class PoolFactory
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RpcPool[]
     */
    protected $pools = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     * @param array $config
     * @return RpcPool
     * @throws NotFoundException
     */
    public function getPool(string $name,array $config): RpcPool
    {
        if (isset($this->pools[$name])) {
            return $this->pools[$name];
        }

        if ($this->container instanceof Container) {
            $pool = $this->container->make(RpcPool::class, ['name' => $name,'config'=>$config]);
        } else {
            $pool = new RpcPool($this->container, $name,$config);
        }
        return $this->pools[$name] = $pool;
    }
}
