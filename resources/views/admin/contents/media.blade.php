@if ($content->img_type == 'file')
    <img src="{{ asset('contents/img/' . $content->img) }}" alt="" width="100%">
@else
    <img src="{{ $content->img }}" alt="" width="100%">
@endif
