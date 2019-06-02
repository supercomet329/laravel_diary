<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Like;
use App\Http\Requests\CreateDiary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DiaryController extends Controller
{

    public function index()
    {
        $diaries = Diary::with('likes')->orderBy('id', 'desc')->paginate(5);

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


        // TODO: isValidだけでチェックできないか確認
        $fileName = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $fileName = $this->saveImage($request->file('image')); //$request->imageでもOK
        }
        

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->user_id = Auth::user()->id;
        $diary->image_path = $fileName;
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

    public function like(int $id)
    {
        $diary = Diary::where('id', $id)->with('likes')->first();

        $diary->likes()->attach(Auth::user()->id);
    }

    public function dislike(int $id)
    {
        $diary = Diary::where('id', $id)->with('likes')->first();

        $diary->likes()->detach(Auth::user()->id);
    }

    private function saveImage($image)
    {
        // Carbonは日付操作のライブラリ
        $dt = Carbon::now();

        // Userごとに年/月のフォルダを作成して画像を保存
        $fileName = $image->store(
            'images/diaries/' .Auth::user()->id . '/' . $dt->year . '/' . $dt->month, 
            'public'
        );

        return $fileName;
    }
}