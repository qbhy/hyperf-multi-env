<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Qbhy\HyperfMultiEnv;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\Utils\ApplicationContext;

/**
 * @Listener
 * Class MultiEnvListener
 */
class MultiEnvListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            BootApplication::class,
        ];
    }

    /**
     * @param BootApplication $event
     */
    public function process(object $event)
    {
        $env = env('APP_ENV');

        if ($env !== null && file_exists($envPath = BASE_PATH . '/.env.' . $env) && ApplicationContext::hasContainer()) {
            $container = ApplicationContext::getContainer();

            $factory = $container->get(ConfigFactory::class);

            $config = $container->get(ConfigInterface::class);

            $newConfig = $factory->merge($env);

            foreach ($newConfig as $key => $value) {
                $config->set($key, $value);
            }
        }
    }
}
