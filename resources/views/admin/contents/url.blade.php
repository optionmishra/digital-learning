@if ($content->src_type == 'file')
    <a href="{{ asset('contents/file' . $content->src) }}"
        target="_blank">{{ asset('contents/file' . $content->src) }}</a>
@else
    <a href="{{ $content->src }}" target="_blank">{{ $content->src }}</a>
@endif
