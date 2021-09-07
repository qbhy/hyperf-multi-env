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

namespace HyperfTest\Cases;

use Dotenv\Dotenv;
use Dotenv\Repository\RepositoryBuilder;
use Dotenv\Repository\Adapter;

/**
 * @internal
 * @coversNothing
 */
class ExampleTest extends AbstractTestCase
{
    public function testExample()
    {
        $this->assertTrue(true);

        $this->assertTrue(extension_loaded('swoole'));
    }

    public function testOverrideEnv()
    {
        $repository = RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(Adapter\PutenvAdapter::class)
            ->addWriter(Adapter\PutenvAdapter::class)
            ->make();

        Dotenv::create($repository,[BASE_PATH])->load();
        $this->assertTrue(env('APP_NAME') === 'default');
        Dotenv::create($repository, [BASE_PATH], '.env.'.env('APP_ENV'))->load();
        $this->assertTrue(env('APP_NAME') === 'testing');
        $this->assertTrue(env('DB_DATABASE') === 'demo_test');
    }
}
