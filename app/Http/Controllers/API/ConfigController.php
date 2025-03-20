<?php

namespace App\Http\Controllers\API;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigResource;

class ConfigController extends Controller
{
    public function index()
    {

        $configs = Config::all();
        if ($configs) return $this->sendAPIResponse(ConfigResource::collection($configs), 'Configs fetched successfully.');
        return $this->sendAPIError('Configs not found.');
    }
}
