<?php

namespace App\Services;

use App\Models\QuestionType;

class QuestionPayload
{
   public static function run(array $data): array
   {
      return array_merge(
         $data, 
         array('className' => (new static)->getClassName($data['question_type_id']))
      );
   }

   private function getClassName(string $type): string
   {
      return QuestionType::find($type)->component_name;
   }
}