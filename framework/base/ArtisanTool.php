<?php

namespace Illuminate\framework\base;

abstract class ArtisanTool
{
    public const MAKE_CONTROLLER = "make:controller";
    public const MAKE_MODEL = "make:model";
    public const MAKE_MIGRATION = "make:migration";
    public const MAKE_MIGRATE = "migrate";

    abstract public function make();
}