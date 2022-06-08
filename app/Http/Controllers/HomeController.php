<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class HomeController extends Controller
{
    public function home()
    {
        return Inertia::render('Home');
    }

    public function jsons($target=null)
    {
        $contents = null;
        $list = [];

        if ($target) {
            if (Storage::disk('jsons')->exists("${target}.json")) {
                $jsonFile = Storage::disk('jsons')->get("${target}.json");
                $contents = json_decode($jsonFile, true);
            }else {
                abort(404);
            }
        }

        $files = Storage::disk('jsons')->allFiles();
        unset($files[0]); // remove .gitkeep file
        foreach ($files as $fileName) {
            $timestamp = Storage::disk('jsons')->lastModified($fileName);
            $date = Carbon::createFromTimestamp($timestamp);
            $key = str_replace('.json', '', $fileName);
            $list []= compact('fileName', 'key', 'date');
        }

        return Inertia::render('Jsons', compact('list', 'contents', 'target'));
    }

    public function downloadJson($target)
    {
        if (Storage::disk('jsons')->exists("${target}.json")) {
            return Storage::disk('jsons')->download("${target}.json");
        }else {
            abort(404);
        }
    }
}
