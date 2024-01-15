<?php

namespace Illuminate\framework\interface;

interface Migration
{
    public function up(): void;
    public function down(): void;
}
