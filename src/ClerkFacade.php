<?php

namespace CLDT\Clerk;

use Illuminate\Support\Facades\Facade;

class ClerkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'clerk';
    }
}
