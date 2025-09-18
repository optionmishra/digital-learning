<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBatchQuestionsRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Models\Assessment;
use App\Models\Book;
use App\Models\Option;
use App\Models\Question;
use App\Models\Series;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Topic;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class QuestionController extends Controller
{
    public $question;

    public function __construct(QuestionRepository $question)
    {
        $this->question = $question;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $standards = Standard::all();
        $subjects = Subject::all();
        $series = Series::all();
        $books = Book::all();
        $topics = Topic::all();
        $assessments = Assessment::all();

        return view('admin.questions.index', compact('standards', 'subjects', 'series', 'books', 'topics', 'assessments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $data = $request->validated();
        $question = $this->question->store($data, $request->input('id'));

        if ($request->hasFile('question_img')) {
            $uploadedFile = $this->uploadFile($request->file('question_img'), 'questions/');
            $question->question_img = $uploadedFile['name'];
            $question->save();
        }
        foreach (range(1, 4) as $i) {
            if ($request->hasFile("option_{$i}_img")) {
                $uploadedFile = $this->uploadFile($request->file("option_{$i}_img"), 'questions/');
                $option_img = $uploadedFile['name'];
            }
            $optionData = [
                'option_text' => $data["option_$i"],
                'option_img' => $option_img ?? null,
                'is_correct' => $data['correct_option'] == $i,
            ];

            if ($request->input('id')) {
                // If the question is being updated, attempt to update the corresponding option.
                // This approach assumes options can be reliably matched to option_1, option_2, etc.
                // by their creation order or ID. A more robust solution for updating options
                // without specific option IDs in the request often involves deleting all
                // existing options for the question and then re-creating them,
                // which would typically be done before this loop.
                $option = $question->options()->orderBy('id')->skip($i - 1)->first();

                if ($option) {
                    $option->update($optionData);
                } else {
                    // If an existing option at this index isn't found, create a new one.
                    $question->options()->create($optionData);
                }
            } else {
                // If it's a new question (no ID in request), simply create the option.
                $question->options()->create($optionData);
            }
        }

        $assessment = Assessment::find($data['assessment_id']);
        $assessment->questions()->syncWithoutDetaching($question->id);

        return $this->jsonResponse((bool) $question, 'Question '.($request->input('id') ? 'updated' : 'created').' successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Question $question)
    {
        $questionDeletion = $question->delete();

        return $this->jsonResponse((bool) $questionDeletion, 'Question deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->question);

        return response()->json($data);
    }

    /**
     * Store batch questions from CSV and ZIP files
     */
    public function storeBatch(StoreBatchQuestionsRequest $request)
    {
        try {
            DB::beginTransaction();

            // Process uploaded files
            $csvFile = $request->file('questions_file');
            $zipFile = $request->file('images_file');
            $imagesPath = null;

            // Extract and process images
            if ($zipFile) {
                $imagesPath = $this->extractImages($zipFile);
            }

            // Process CSV file
            $questions = $this->processCsvFile($csvFile, $imagesPath);

            // Store questions in database
            $storedQuestions = $this->storeQuestions($questions, $request);

            DB::commit();

            // Clean up temporary files
            if ($zipFile) {
                $this->cleanupTempFiles($imagesPath);
            }

            return response()->json([
                'success' => true,
                'message' => 'Questions imported successfully',
                'data' => [
                    'total_questions' => count($storedQuestions),
                    'imported_questions' => $storedQuestions,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Batch questions import failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to import questions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Extract images from ZIP file
     */
    private function extractImages($zipFile): string
    {
        $extractPath = storage_path('app/temp/question_images_'.time());

        if (! is_dir($extractPath)) {
            mkdir($extractPath, 0755, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipFile->getRealPath()) === true) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            throw new \Exception('Failed to extract images ZIP file');
        }

        return $extractPath;
    }

    /**
     * Process CSV file and return structured data
     */
    private function processCsvFile($csvFile, ?string $imagesPath = null): array
    {
        $questions = [];
        $csvData = array_map('str_getcsv', file($csvFile->getRealPath()));
        // dd($csvData);

        // Skip header row
        $headers = array_shift($csvData);

        // Remove BOM from first header if present
        if (isset($headers[0])) {
            $headers[0] = trim($headers[0], "\xEF\xBB\xBF");
        }

        // Clean all headers
        $headers = array_map('trim', $headers);

        // Validate CSV headers
        $requiredHeaders = [
            'question_text', 'question_img',
            'option_1', 'option_1_img', 'option_2', 'option_2_img', 'option_3', 'option_3_img', 'option_4', 'option_4_img',
            'correct_option',
        ];

        foreach ($requiredHeaders as $header) {
            if (! in_array($header, $headers)) {
                throw new \Exception("Missing required CSV header: {$header}");
            }
        }

        foreach ($csvData as $rowIndex => $row) {
            if (empty(array_filter($row))) {
                continue;
            } // Skip empty rows

            $rowData = array_combine($headers, $row);

            // Validate row data
            $this->validateRowData($rowData, $rowIndex + 2); // +2 for header and 0-based index

            // Process question image if exists
            $questionImage = null;
            if ($imagesPath) {
                if (! empty($rowData['question_img'])) {
                    $questionImage = $this->processQuestionImage($rowData['question_img'], $imagesPath);
                }
            }

            // Prepare options
            $options = [];
            for ($i = 1; $i <= 4; $i++) {
                // Process option image if exists
                $optionImage = null;
                if ($imagesPath) {
                    if (! empty($rowData["option_{$i}_img"])) {
                        $optionImage = $this->processQuestionImage($rowData["option_{$i}_img"], $imagesPath);
                    }
                }

                $optionText = trim($rowData["option_{$i}"]);
                if (! empty($optionText)) {
                    $options[] = [
                        'option_text' => $optionText,
                        'option_img' => $optionImage,
                        'is_correct' => ($i == (int) $rowData['correct_option']) ? 1 : 0,
                    ];
                }
            }

            if (empty($options)) {
                throw new \Exception('No valid options found for question at row '.($rowIndex + 2));
            }

            // Validate that at least one correct option exists
            $hasCorrectOption = collect($options)->contains('is_correct', 1);
            if (! $hasCorrectOption) {
                throw new \Exception('No correct option specified for question at row '.($rowIndex + 2));
            }

            $questions[] = [
                'question_text' => trim($rowData['question_text']),
                'question_img' => $questionImage ?: null,
                // 'question_type_id' => (int) $rowData['question_type_id'],
                'options' => $options,
            ];
        }

        return $questions;
    }

    /**
     * Validate individual row data
     */
    private function validateRowData(array $rowData, int $rowNumber): void
    {
        // Validate question text
        if (empty(trim($rowData['question_text']))) {
            throw new \Exception("Question text is required at row {$rowNumber}");
        }

        // Validate question type ID
        // if (empty($rowData['question_type_id']) || ! is_numeric($rowData['question_type_id'])) {
        //     throw new \Exception("Valid question_type_id is required at row {$rowNumber}");
        // }

        // Validate correct option
        $correctOption = (int) $rowData['correct_option'];
        if ($correctOption < 1 || $correctOption > 4) {
            throw new \Exception("correct_option must be between 1-4 at row {$rowNumber}");
        }

        // Validate that the correct option has text
        if (empty(trim($rowData["option_{$correctOption}"]))) {
            throw new \Exception("The correct option (option_{$correctOption}) cannot be empty at row {$rowNumber}");
        }
    }

    /**
     * Process question image
     */
    private function processQuestionImage(string $imageName, string $imagesPath): ?string
    {
        $imagePath = $imagesPath.'/'.$imageName;

        if (! file_exists($imagePath)) {
            Log::warning("Image file not found: {$imageName}");

            return null;
        }

        // Generate unique filename
        $extension = pathinfo($imageName, PATHINFO_EXTENSION);
        $newFilename = Str::uuid().'.'.$extension;

        // Store image in public storage
        $imageContent = file_get_contents($imagePath);
        Storage::disk('public')->put('questions/'.$newFilename, $imageContent);

        return $newFilename;
    }

    /**
     * Store questions in database
     */
    private function storeQuestions(array $questions, StoreBatchQuestionsRequest $request): array
    {
        $storedQuestions = [];

        foreach ($questions as $questionData) {
            // Create question
            $question = Question::create([
                'question_text' => $questionData['question_text'],
                'question_img' => $questionData['question_img'],
                'subject_id' => $request->subject_id,
                'book_id' => $request->book_id,
                'topic_id' => $request->topic_id,
                // 'question_type_id' => $questionData['question_type_id'],
            ]);

            $assessment = Assessment::find($request->assessment_id);
            $assessment->questions()->syncWithoutDetaching($question->id);

            // Create options
            $options = [];
            foreach ($questionData['options'] as $optionData) {
                $option = Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['option_text'],
                    'option_img' => $optionData['option_img'],
                    'is_correct' => $optionData['is_correct'],
                ]);
                $options[] = $option;
            }

            $storedQuestions[] = [
                'question_id' => $question->id,
                'question_text' => $question->question_text,
                'options_count' => count($options),
                'has_image' => ! empty($question->question_img),
            ];
        }

        return $storedQuestions;
    }

    /**
     * Clean up temporary files
     */
    private function cleanupTempFiles(string $tempPath): void
    {
        if (is_dir($tempPath)) {
            $this->deleteDirectory($tempPath);
        }
    }

    /**
     * Recursively delete directory
     */
    private function deleteDirectory(string $dir): bool
    {
        if (! is_dir($dir)) {
            return false;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $filePath = $dir.'/'.$file;
            is_dir($filePath) ? $this->deleteDirectory($filePath) : unlink($filePath);
        }

        return rmdir($dir);
    }

    /**
     * Download sample CSV template
     */
    public function downloadTemplate()
    {
        $csvContent = [
            ['question_text', 'question_img', 'option_1', 'option_1_img', 'option_2', 'option_2_img', 'option_3', 'option_3_img', 'option_4', 'option_4_img', 'correct_option'],
            ['What is the capital of France?', 'france_map.jpg', 'Paris', '', 'London', '', 'Berlin', '', 'Madrid', '', '1'],
            ['Which planet is closest to the Sun?', '', 'Venus', '', 'Mercury', '', 'Earth', '', 'Mars', '', '2'],
            ['What is 2 + 2?', 'math_problem.png', '3', '', '4', '', '5', '', '6', '', '2'],
        ];

        $filename = 'questions_template.csv';
        $handle = fopen('php://temp', 'w+');

        foreach ($csvContent as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csvOutput = stream_get_contents($handle);
        fclose($handle);

        return response($csvOutput)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}
