<?php

namespace App\Repositories;

use App\Models\Question;
use App\Repositories\Contracts\QuestionRepositoryInterface;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    public $question;

    public function __construct(Question $question)
    {
        parent::__construct($question);
        $this->question = $question;
    }

    public function paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->question->select('*');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('title', 'LIKE', "%$searchValue%")
                    ->orWhere('content', 'LIKE', "%$searchValue%");
                // ->orWhereHas('category', function ($q) use ($searchValue) {
                //     $q->where('title', 'LIKE', "%$searchValue%");
                // });
            });
        }

        if (! empty($sortColumn)) {
            switch (strtolower($sortColumn)) {
                case '#':
                    $sortColumn = 'id';
                    break;
                    // case "category":
                    //     $sortColumn = 'category_id';
                    //     break;
                default:
                    $sortColumn = strtolower($sortColumn);
                    break;
            }
            $query->orderBy($sortColumn, $sortDirection);
        }

        $count = $query->count();

        if ($countOnly) {
            return $count;
        }

        $query->skip($start)->take($length);
        $questions = $query->get();
        $questions = $this->collectionModifier($columns, $questions, $start);

        return $questions;
    }

    public function collectionModifier($columns, $questions, $start)
    {
        array_push($columns, 'correct_option,assessment_id');

        return $questions->map(function ($question, $key) use ($columns, $start) {
            $question->serial = $start + 1 + $key;
            // $question->image = view('admin.questions.media', compact('question'))->render();
            $question->subject_name = $question->subject->name;
            $question->book_name = $question->book->name;
            $question->topic_name = $question->topic->name;
            $question->assessment_name = $question->assessment[0]->name ?? null;
            $question->assessment_id = $question->assessment[0]->id ?? null;
            $question->question = $question->question_text;

            // Safely access options with null coalescing
            $question->option_1 = $question->options[0]->option_text ?? null;
            $question->option_2 = $question->options[1]->option_text ?? null;
            $question->option_3 = $question->options[2]->option_text ?? null;
            $question->option_4 = $question->options[3]->option_text ?? null;

            $question->answer = $question->correctOption->option_text ?? null;

            // Find correct option more safely
            $correctOptionNumber = null;
            foreach ($question->options as $index => $option) {
                if ($option->is_correct) {
                    $correctOptionNumber = $index + 1;
                    break;
                }
            }
            $question->correct_option = $correctOptionNumber;

            $question->actions = view('admin.questions.actions', compact('question'))->render();
            $question->setVisible($columns);

            return $question;
        });
    }
}
