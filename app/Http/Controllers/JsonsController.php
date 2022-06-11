<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Storage;

class JsonsController extends Controller
{
    public function list()
    {
        $files = Storage::disk('jsons')->allFiles();
        unset($files[0]); // remove .gitkeep file
        foreach ($files as $fileName) {
            $timestamp = Storage::disk('jsons')->lastModified($fileName);
            $date = Carbon::createFromTimestamp($timestamp);
            $key = str_replace('.json', '', $fileName);
            $list []= compact('fileName', 'key', 'date');
        }

        return Inertia::render('Jsons/List', compact('list'));
    }

    public function show($target)
    {
        if (Storage::disk('jsons')->exists("${target}.json")) {
            $jsonFile = Storage::disk('jsons')->get("${target}.json");
            $contents = json_decode($jsonFile, true);
        }else {
            abort(404);
        }
        return Inertia::render('Jsons/Show', compact('contents', 'target'));
    }

    public function download($target)
    {
        if (Storage::disk('jsons')->exists("${target}.json")) {
            return Storage::disk('jsons')->download("${target}.json");
        }else {
            abort(404);
        }
    }

    public function destroy($target)
    {
        if (Storage::disk('jsons')->exists("${target}.json")) {
            $result = Storage::disk('jsons')->delete("${target}.json");
            return ['success' => $result];
        }else {
            abort(404);
        }
    }
}
