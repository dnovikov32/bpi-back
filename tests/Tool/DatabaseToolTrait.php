<?php

declare(strict_types=1);

namespace App\Tests\Tool;

use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

trait DatabaseToolTrait
{
    private ?AbstractDatabaseTool $databaseTool = null;

    public function getDatabaseTool(): AbstractDatabaseTool
    {
        if ($this->databaseTool === null) {
            $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        }

        return $this->databaseTool;
    }
}
