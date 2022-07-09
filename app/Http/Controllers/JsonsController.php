<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Storage;

class JsonsController extends Controller
{
    public function list($folder='health')
    {
        $files = collect(Storage::disk('jsons')->allFiles($folder))->sortByDesc(function ($file) {
            $timestamp = Storage::disk('jsons')->lastModified($file);
            return $timestamp;
        });
        unset($files[0]); // remove .gitkeep file
        foreach ($files as $fileName) {
            $timestamp = Storage::disk('jsons')->lastModified($fileName);
            $date = Carbon::createFromTimestamp($timestamp);
            $key = str_replace($folder.'/', '', $fileName);
            $list []= compact('fileName', 'key', 'date');
        }

        return Inertia::render('Jsons/List', compact('list', 'folder'));
    }

    public function show($folder, $target)
    {
        if (Storage::disk('jsons')->exists("${folder}/${target}")) {
            $contents = Storage::disk('jsons')->get("${folder}/${target}");
        }else {
            abort(404);
        }
        return Inertia::render('Jsons/Show', compact('contents', 'target'));
    }

    public function download($folder, $target)
    {
        if (Storage::disk('jsons')->exists("${folder}/${target}")) {
            return Storage::disk('jsons')->download("${folder}/${target}");
        }else {
            abort(404);
        }
    }

    public function destroy($folder, $target)
    {
        if (Storage::disk('jsons')->exists("${folder}/${target}")) {
            $result = Storage::disk('jsons')->delete("${folder}/${target}");
            return ['success' => $result];
        }
    }

    public function groupDestroy($folder, Request $request)
    {
        foreach ($request->all() as $target) {
            if (Storage::disk('jsons')->exists("${folder}/${target}")) {
                $result = Storage::disk('jsons')->delete("${folder}/${target}");
                dd($result);
            }
        }
        return ['success' => true];
    }
}
