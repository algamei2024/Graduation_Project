<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MyFiles extends Controller
{
    public $folder_name;
    public function __construct()
    {
        $this->folder_name = 'myFolder';
    }
    public function create(Request $request, $fileName)
    {
        // $content = '<h1>tag from backEnd</h1>';
        $content = $request->input('header');
        $style = $request->input('style');

        $decodeContent = urldecode($content);
        $decodeStyle = urldecode($style);

        // $fullData = $decodeStyle . PHP_EOL . $decodeContent; // تحميع البيانات مع نزول سطر
        // Storage::put("$this->folder_name/$fileName", $fullData);

        Storage::put("$this->folder_name/$fileName.html", $decodeContent);
        Storage::put("$this->folder_name/$fileName.css", $decodeStyle);

        return response()->json([
            'msg' => ' تم إنشاء الملف ' . $fileName,
        ]);
    }
    public function sendFile($fileName)
    {
        $path_fileContent = "$this->folder_name/$fileName.html";
        $path_fileStyle = "$this->folder_name/$fileName.css";
        $content = Storage::get($path_fileContent);
        $style = Storage::get($path_fileStyle);
        return response()->json([
            'content' => $content,
            'style' => $style,
        ]);
    }
}
