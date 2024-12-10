<div class="d-flex">
    <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center edit-btn" type="button" title="Edit"
        data-coreui-toggle="modal" data-coreui-target="#questionStore"
        data-update-route="{{ route('admin.questions.store') }}"
        data-row-data="{{ json_encode(['id' => $question->id, 'subject_id' => $question->subject_id, 'book_id' => $question->book_id, 'topic_id' => $question->topic_id, 'assessment_id' => $question->assessment_id, 'question_text' => $question->question_text, 'option_1' => $question->option_1, 'option_2' => $question->option_2, 'option_3' => $question->option_3, 'option_4' => $question->option_4, 'correct_option' => $question->correct_option]) }}">
        <svg class="icon icon-lg text-primary">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
            </use>
        </svg>
    </button>
    <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button" title="Delete"
        data-coreui-toggle="modal" data-coreui-target="#deleteModal"
        data-delete-route="{{ route('admin.questions.destroy', $question->id) }}">
        <svg class="icon icon-lg text-danger">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
            </use>
        </svg>
    </button>
</div>
