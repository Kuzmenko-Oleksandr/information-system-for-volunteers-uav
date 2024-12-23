<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Services\Admin\PostService;

class BaseController extends Controller
{
    protected $service;

    public function __construct(PostService $service){
        $this->service = $service;
    }
}
