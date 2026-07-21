<?php

namespace Scrapkit\QuickLogin\Tests\TestSupport;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Scrapkit\QuickLogin\Tests\TestCase;

class WithHierarchyTestCase extends TestCase
{
    protected function defineDatabaseMigrations(): void
    {
        parent::defineDatabaseMigrations();

        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedInteger('hierarchy_rank')->default(0);
        });
    }
}
