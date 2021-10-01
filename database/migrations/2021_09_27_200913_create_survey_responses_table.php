<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->text('user_agent');
            $table->string('ip_address')->nullable();
            $table->foreignIdFor(\App\Models\Survey::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Question::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\OfferedAnswer::class)->nullable();
            $table->text('other_text')->nullable();
            $table->text('answer_text')->nullable();
            $table->tinyInteger('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_responses');
    }
}
