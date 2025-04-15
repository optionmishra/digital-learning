<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Question;
use App\Models\Standard;
use App\Models\Assessment;
use App\Models\QuestionType;
use App\Models\StandardSubject;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $englishSubject = Subject::where('name', 'English')->first();
        $englishBook = $englishSubject->books()->first();
        $englishTopic = $englishSubject->topics()->first();
        // $englishSeries = $englishSubject->assessments()->first();

        $questionTypeMultipleChoice = QuestionType::where('name', 'Multiple Choice')->firstOrCreate([
            'name' => 'Multiple Choice',
        ]);
        $questionTypeFillInTheBlank = QuestionType::where('name', 'Fill in the Blank')->firstOrCreate([
            'name' => 'Fill in the Blank',
        ]);

        $question1 = Question::firstOrCreate(
            ['question_text' => 'Which of the following sentences is in the passive voice?'],
            [
                'subject_id' => $englishSubject->id,
                'book_id' => $englishBook->id,
                'topic_id' => $englishTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
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
                'question_type_id' => $questionTypeMultipleChoice->id,
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
                'question_type_id' => $questionTypeFillInTheBlank->id,
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
                'question_type_id' => $questionTypeMultipleChoice->id,
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
                'question_type_id' => $questionTypeMultipleChoice->id,
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

        // Science Olympiad
        $scienceSubject = Subject::where('name', 'Science')->first();
        $scienceBook = $scienceSubject->books()->firstOrCreate(
            ['name' => 'Science book'],
            [
                'about' => 'This is a science book',
                'board_id' => 1,
                'standard_id' => 1,
                'author_id' => 1,
            ]
        );
        $scienceTopic = $scienceSubject->topics()->firstOrCreate(['name' => 'Space'], [
            'book_id' => $scienceBook->id,
        ]);

        $assessment = Assessment::firstOrCreate(
            ['name' => 'Science Olympiad'],
            [
                'type' => 'olympiad',
                'standard_id' => 1,
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'duration' => "00:10:00"
            ]
        );

        $question1 = Question::firstOrCreate(
            ['question_text' => 'What is the chemical symbol for water?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question1->options()->firstOrCreate(['option_text' => 'O2', 'is_correct' => false]);
        $question1->options()->firstOrCreate(['option_text' => 'H2O', 'is_correct' => true]);
        $question1->options()->firstOrCreate(['option_text' => 'CO2', 'is_correct' => false]);
        $question1->options()->firstOrCreate(['option_text' => 'NaCl', 'is_correct' => false]);

        $question2 = Question::firstOrCreate(
            ['question_text' => 'What planet is known as the Red Planet?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question2->options()->firstOrCreate(['option_text' => 'Earth', 'is_correct' => false]);
        $question2->options()->firstOrCreate(['option_text' => 'Mars', 'is_correct' => true]);
        $question2->options()->firstOrCreate(['option_text' => 'Venus', 'is_correct' => false]);
        $question2->options()->firstOrCreate(['option_text' => 'Jupiter', 'is_correct' => false]);

        $question3 = Question::firstOrCreate(
            ['question_text' => 'Which gas is most abundant in the Earth\'s atmosphere?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question3->options()->firstOrCreate(['option_text' => 'Oxygen', 'is_correct' => false]);
        $question3->options()->firstOrCreate(['option_text' => 'Nitrogen', 'is_correct' => true]);
        $question3->options()->firstOrCreate(['option_text' => 'Carbon Dioxide', 'is_correct' => false]);
        $question3->options()->firstOrCreate(['option_text' => 'Hydrogen', 'is_correct' => false]);

        $question4 = Question::firstOrCreate(
            ['question_text' => 'What is the boiling point of water in Celsius?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question4->options()->firstOrCreate(['option_text' => '100°C', 'is_correct' => true]);
        $question4->options()->firstOrCreate(['option_text' => '50°C', 'is_correct' => false]);
        $question4->options()->firstOrCreate(['option_text' => '0°C', 'is_correct' => false]);
        $question4->options()->firstOrCreate(['option_text' => '25°C', 'is_correct' => false]);

        $question5 = Question::firstOrCreate(
            ['question_text' => 'What is the hardest natural substance on Earth?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question5->options()->firstOrCreate(['option_text' => 'Gold', 'is_correct' => false]);
        $question5->options()->firstOrCreate(['option_text' => 'Iron', 'is_correct' => false]);
        $question5->options()->firstOrCreate(['option_text' => 'Diamond', 'is_correct' => true]);
        $question5->options()->firstOrCreate(['option_text' => 'Silver', 'is_correct' => false]);

        $question6 = Question::firstOrCreate(
            ['question_text' => 'Which planet has the most moons?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question6->options()->firstOrCreate(['option_text' => 'Jupiter', 'is_correct' => true]);
        $question6->options()->firstOrCreate(['option_text' => 'Earth', 'is_correct' => false]);
        $question6->options()->firstOrCreate(['option_text' => 'Mars', 'is_correct' => false]);
        $question6->options()->firstOrCreate(['option_text' => 'Saturn', 'is_correct' => false]);

        $question7 = Question::firstOrCreate(
            ['question_text' => 'What is the center of an atom called?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question7->options()->firstOrCreate(['option_text' => 'Electron', 'is_correct' => false]);
        $question7->options()->firstOrCreate(['option_text' => 'Nucleus', 'is_correct' => true]);
        $question7->options()->firstOrCreate(['option_text' => 'Proton', 'is_correct' => false]);
        $question7->options()->firstOrCreate(['option_text' => 'Neutron', 'is_correct' => false]);

        $question8 = Question::firstOrCreate(
            ['question_text' => 'Which organelle is known as the powerhouse of the cell?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question8->options()->firstOrCreate(['option_text' => 'Nucleus', 'is_correct' => false]);
        $question8->options()->firstOrCreate(['option_text' => 'Mitochondria', 'is_correct' => true]);
        $question8->options()->firstOrCreate(['option_text' => 'Ribosome', 'is_correct' => false]);
        $question8->options()->firstOrCreate(['option_text' => 'Golgi Apparatus', 'is_correct' => false]);

        $question9 = Question::firstOrCreate(
            ['question_text' => 'What is the process of converting water vapor into liquid water called?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question9->options()->firstOrCreate(['option_text' => 'Evaporation', 'is_correct' => false]);
        $question9->options()->firstOrCreate(['option_text' => 'Condensation', 'is_correct' => true]);
        $question9->options()->firstOrCreate(['option_text' => 'Sublimation', 'is_correct' => false]);
        $question9->options()->firstOrCreate(['option_text' => 'Transpiration', 'is_correct' => false]);

        $question10 = Question::firstOrCreate(
            ['question_text' => 'What type of rock is formed by volcanic activity?'],
            [
                'subject_id' => $scienceSubject->id,
                'book_id' => $scienceBook->id,
                'topic_id' => $scienceTopic->id,
                'question_type_id' => $questionTypeMultipleChoice->id,
            ]
        );
        $question10->options()->firstOrCreate(['option_text' => 'Sedimentary', 'is_correct' => false]);
        $question10->options()->firstOrCreate(['option_text' => 'Igneous', 'is_correct' => true]);
        $question10->options()->firstOrCreate(['option_text' => 'Metamorphic', 'is_correct' => false]);
        $question10->options()->firstOrCreate(['option_text' => 'Limestone', 'is_correct' => false]);

        $assessment->questions()->sync([$question1->id, $question2->id, $question3->id, $question4->id, $question5->id, $question6->id, $question7->id, $question8->id, $question9->id, $question10->id]);

        // First clear the table to avoid duplicate entries
        DB::table('standard_subjects')->truncate();

        // Get all standards and subjects
        $standards = Standard::all();
        $subjects = Subject::all();

        // Create records for each combination
        foreach ($standards as $standard) {
            foreach ($subjects as $subject) {
                StandardSubject::create([
                    'standard_id' => $standard->id,
                    'subject_id' => $subject->id,
                ]);
            }
        }

        Subject::firstOrCreate(
            ['name' => 'Literature'],
            ['img' => 'Social-Science.png']
        );
    }
}
