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

use Dotenv\Dotenv;
use Dotenv\Repository\RepositoryBuilder;
use Hyperf\Config\ProviderConfig;
use Symfony\Component\Finder\Finder;
use Dotenv\Repository\Adapter;

class ConfigFactory
{
    public function merge($env)
    {
        // Load env before config.
        if (file_exists(BASE_PATH . '/.env.' . $env)) {
            $repository = RepositoryBuilder::createWithNoAdapters()
                ->addReader(
                    Adapter\PutenvAdapter::class
                )
                ->addWriter(
                    Adapter\PutenvAdapter::class
                )
                ->make();

            Dotenv::create($repository, [BASE_PATH], '.env.' . $env)->load();
        }

        $configPath = BASE_PATH . '/config/';
        $config = $this->readConfig($configPath . 'config.php');
        $serverConfig = $this->readConfig($configPath . 'server.php');
        $autoloadConfig = $this->readPaths([BASE_PATH . '/config/autoload']);

        return array_merge_recursive(ProviderConfig::load(), $serverConfig, $config, ...$autoloadConfig);
    }

    private function readConfig(string $configPath): array
    {
        $config = [];
        if (file_exists($configPath) && is_readable($configPath)) {
            $config = require $configPath;
        }
        return is_array($config) ? $config : [];
    }

    private function readPaths(array $paths)
    {
        $configs = [];
        $finder = new Finder();
        $finder->files()->in($paths)->name('*.php');
        foreach ($finder as $file) {
            $configs[] = [
                $file->getBasename('.php') => require $file->getRealPath(),
            ];
        }
        return $configs;
    }
}
