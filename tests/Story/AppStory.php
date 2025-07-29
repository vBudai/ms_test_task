<?php

namespace App\Tests\Story;

use App\Tests\Factory\ProductFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public function build(): void
    {
        ProductFactory::createMany(10);
    }
}
