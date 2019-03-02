<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Http\Requests\CreateDiary;

class DiaryController extends Controller
{
    public function index()
    {
        $diaries = Diary::all(); //diariesテーブルのデータを全件取得

        return view('diaries.index',[
            'diaries' => $diaries,
        ]);
    }

    public function create()
    {
        return view('diaries.create');
    }

    public function store(CreateDiary $request)
    {
        $diary = new Diary(); //Diaryモデルをインスタンス化

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }

    public function edit(int $id)
    {
        $diary = Diary::find($id);

        return view('diaries.edit', [
            'diary' => $diary,
        ]);
    }

    public function update(int $id, CreateDiary $request)
    {
        $diary = Diary::find($id);

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }

    public function destroy(int $id)
    {
        $diary = Diary::find($id);
        $diary->delete();

        return redirect()->route('diary.index');
    }
}