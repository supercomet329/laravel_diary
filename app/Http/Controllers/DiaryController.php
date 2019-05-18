<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Http\Requests\CreateDiary;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    public function index()
    {

        $diaries = Diary::orderBy('id', 'desc')->get();

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
        $diary->user_id = Auth::user()->id;
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }

    public function edit(Diary $diary)
    {
        if (Auth::user()->id !== $diary->user_id) {
            abort(403);
        }

        return view('diaries.edit', [
            'diary' => $diary,
        ]);
    }

    public function update(Diary $diary, CreateDiary $request)
    {
        if (Auth::user()->id !== $diary->user_id) {
            abort(403);
        }

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }

    public function destroy(Diary $diary)
    {
        if (Auth::user()->id !== $diary->user_id) {
            abort(403);
        }
        
        $diary->delete();

        return redirect()->route('diary.index');
    }
}