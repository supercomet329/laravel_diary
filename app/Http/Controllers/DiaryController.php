<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;

class DiaryController extends Controller
{
    public function index()
    {
        $diaries = Diary::all(); //diariesテーブルのデータを全件取得

        return view('diaries.index',[
            'diaries' => $diaries,
        ]);
    }
}