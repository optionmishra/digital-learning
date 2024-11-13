<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Question;
use App\Models\Assessment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $englishSubject = Subject::where('name', 'English')->first();
        $englishBook = $englishSubject->books()->first();
        $englishTopic = $englishSubject->topics()->first();
        $englishSeries = $englishSubject->assessments()->first();

        $question1 = Question::firstOrCreate(
            ['question_text' => 'Which of the following sentences is in the passive voice?'],
            [
                'subject_id' => $englishSubject->id,
                'book_id' => $englishBook->id,
                'topic_id' => $englishTopic->id,
            ]
        );

        $question1->options()->firstOrCreate([
            'option_text' => 'The chef cooked a delicious meal.',
            'is_correct' => false
        ]);
        $question1->options()->firstOrCreate([
            'option_text' => 'The meal was cooked by the chef.',
            'is_correct' => true
        ]);
        $question1->options()->firstOrCreate([
            'option_text' => 'The chef will cook the meal.',
            'is_correct' => false
        ]);
        $question1->options()->firstOrCreate([
            'option_text' => 'The chef is cooking the meal.',
            'is_correct' => false
        ]);

        $question2 = Question::firstOrCreate(
            ['question_text' => 'Identify the active voice sentence:'],
            [
                'subject_id' => $englishSubject->id,
                'book_id' => $englishBook->id,
                'topic_id' => $englishTopic->id,
            ]
        );

        $question2->options()->firstOrCreate([
            'option_text' => 'The project will be completed by Sarah.',
            'is_correct' => false
        ]);
        $question2->options()->firstOrCreate([
            'option_text' => 'Sarah will complete the project.',
            'is_correct' => true
        ]);
        $question2->options()->firstOrCreate([
            'option_text' => 'The project has been completed by Sarah.',
            'is_correct' => false
        ]);
        $question2->options()->firstOrCreate([
            'option_text' => 'The project was completed by Sarah.',
            'is_correct' => false
        ]);

        $question3 = Question::firstOrCreate(
            ['question_text' => 'Change this sentence to passive voice: "The teacher explains the lesson."'],
            [
                'subject_id' => $englishSubject->id,
                'book_id' => $englishBook->id,
                'topic_id' => $englishTopic->id,
            ]
        );

        $question3->options()->firstOrCreate([
            'option_text' => 'The lesson is explained by the teacher.',
            'is_correct' => true
        ]);
        $question3->options()->firstOrCreate([
            'option_text' => 'The lesson was explained by the teacher.',
            'is_correct' => false
        ]);
        $question3->options()->firstOrCreate([
            'option_text' => 'The teacher is explaining the lesson.',
            'is_correct' => false
        ]);
        $question3->options()->firstOrCreate([
            'option_text' => 'The teacher explained the lesson.',
            'is_correct' => false
        ]);

        $question4 = Question::firstOrCreate(
            ['question_text' => 'In the passive voice, "The manager is reviewing the report" becomes:'],
            [
                'subject_id' => $englishSubject->id,
                'book_id' => $englishBook->id,
                'topic_id' => $englishTopic->id,
            ]
        );

        $question4->options()->firstOrCreate([
            'option_text' => 'The report was reviewed by the manager.',
            'is_correct' => false
        ]);
        $question4->options()->firstOrCreate([
            'option_text' => 'The report has been reviewed by the manager.',
            'is_correct' => false
        ]);
        $question4->options()->firstOrCreate([
            'option_text' => 'The report is being reviewed by the manager.',
            'is_correct' => true
        ]);
        $question4->options()->firstOrCreate([
            'option_text' => 'The report will be reviewed by the manager.',
            'is_correct' => false
        ]);

        $question5 = Question::firstOrCreate(
            ['question_text' => 'Which of the following sentences is in the active voice?'],
            [
                'subject_id' => $englishSubject->id,
                'book_id' => $englishBook->id,
                'topic_id' => $englishTopic->id,
            ]
        );

        $question5->options()->firstOrCreate([
            'option_text' => 'The book was read by her in one day.',
            'is_correct' => false
        ]);
        $question5->options()->firstOrCreate([
            'option_text' => 'The story has been told by the author.',
            'is_correct' => false
        ]);
        $question5->options()->firstOrCreate([
            'option_text' => 'She read the book in one day.',
            'is_correct' => true
        ]);
        $question5->options()->firstOrCreate([
            'option_text' => 'The poem was written by him.',
            'is_correct' => false
        ]);

        $assessment = Assessment::find(1);
        $assessment->questions()->sync([$question1->id, $question2->id, $question3->id, $question4->id, $question5->id]);
    }
}
