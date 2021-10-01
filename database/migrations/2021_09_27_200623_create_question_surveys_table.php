<?php

use App\Models\Question;
use App\Models\QuestionType;
use App\Models\Survey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Survey::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Question::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(QuestionType::class)->constrained()->onDelete('cascade');
            $table->boolean('is_open')->default(true);
            $table->tinyInteger('min')->default(0);
            $table->tinyInteger('max')->default(10);
            $table->tinyInteger('center')->default(5);
            $table->tinyInteger('scale')->default(5);
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
        Schema::dropIfExists('question_surveys');
    }
}
