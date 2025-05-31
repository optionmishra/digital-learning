<?php

namespace App\Http\Controllers\API;

use App\Models\Subject;
use App\Models\ContentType;
use App\Http\Controllers\Controller;
use App\Http\Resources\EbookResource;
use App\Http\Resources\VideoResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\EbooksResource;
use App\Http\Resources\VideosResource;
use App\Http\Resources\SubjectsResource;

class ContentController extends Controller
{
  // Videos
  public function getThreeRandomVideos()
  {
    $videoContentType = ContentType::whereName("Video")->first();
    $videos = $videoContentType
      ->classContents()
      ->inRandomOrder()
      ->limit(3)
      ->get();
    return $this->sendAPIResponse(
      [
        "banners" => BannerResource::make(null),
        "videos" => VideosResource::collection($videos),
        "subjects" => SubjectsResource::collection(Subject::all()),
      ],
      "Videos fetched successfully."
    );
  }

  public function getVideosBySubjectId(string $id)
  {
    $videoContentType = ContentType::whereName("Video")->first();
    $videos = $videoContentType
      ->classContents()
      ->where("subject_id", $id)
      ->get();
    if ($videos->count()) {
      return $this->sendAPIResponse(
        VideosResource::collection($videos),
        "Videos fetched successfully."
      );
    }
    return $this->sendAPIError("Videos not found.");
  }

  public function showVideo(string $id)
  {
    $videoContentType = ContentType::whereName("Video")->first();
    $video = $videoContentType->contents()->find($id);
    if ($video) {
      return $this->sendAPIResponse(
        VideoResource::make($video),
        "Video fetched successfully."
      );
    }
    return $this->sendAPIError("Video not found.");
  }

  // Ebooks
  public function getEbooksBySubjectId(string $id)
  {
    $ebookContentType = ContentType::whereName(
      "E-Book \ Flipbook"
    )->first();
    $ebooks = $ebookContentType
      ->classContents()
      ->where("subject_id", $id)
      ->get();
    if ($ebooks->count()) {
      return $this->sendAPIResponse(
        EbooksResource::collection($ebooks),
        "Ebooks fetched successfully."
      );
    }
    return $this->sendAPIError("Ebooks not found.");
  }

  public function showEbook(string $id)
  {
    $ebookContentType = ContentType::whereName(
      "E-Book \ Flipbook"
    )->first();
    $ebook = $ebookContentType->contents()->find($id);
    if ($ebook) {
      return $this->sendAPIResponse(
        EbookResource::make($ebook),
        "Ebook fetched successfully."
      );
    }
    return $this->sendAPIError("Ebook not found.");
  }
}
