@if ($content->src_type == 'file' && isset($content->src))
    <a href="{{ asset('contents/file/' . $content->src) }}"
        target="_blank">{{ asset('contents/file/' . $content->src) }}</a>
@elseif($content->src_type == 'url' && isset($content->src))
    <a href="{{ $content->src }}" target="_blank">{{ $content->src }}</a>
@endif
