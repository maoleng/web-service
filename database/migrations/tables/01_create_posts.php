<?php

use Libraries\migrations\Migration;

return new class extends Migration {

    public string $table = 'students';

    public function up(): void
    {
        $this->id();
        $this->string('name')->nullable();
        $this->text('description');
        $this->string('student_card_id', 10)->unique();
    }
};