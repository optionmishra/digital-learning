<div class="d-flex">
    <button class="btn btn-link nav-link d-flex align-items-center edit-btn px-2 py-2" type="button" title="Edit"
        data-coreui-toggle="modal" data-coreui-target="#contentStore"
        data-update-route="{{ route('admin.contents.store') }}"
        data-row-data="{{ json_encode(['id' => $content->id, 'title' => $content->title, 'tags' => $content->tags, 'img_type' => $content->img_type, 'img_url' => $content->img, 'src_type' => $content->src_type, 'url' => $content->src, 'price' => $content->price, 'about' => $content->about, 'standard_id' => $content->standard_id, 'subject_id' => $content->subject_id, 'book_id' => $content->book_id, 'topic_id' => $content->topic_id, 'duration' => $content->duration]) }}">
        <svg class="icon icon-lg text-primary">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
            </use>
        </svg>
    </button>
    <button class="btn btn-link nav-link d-flex align-items-center px-2 py-2" type="button" title="Delete"
        data-coreui-toggle="modal" data-coreui-target="#deleteModal"
        data-delete-route="{{ route('admin.contents.destroy', $content->id) }}">
        <svg class="icon icon-lg text-danger">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
            </use>
        </svg>
    </button>
</div>
