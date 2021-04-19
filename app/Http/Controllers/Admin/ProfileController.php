<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
public function add()
{
    return view('admin.profile.create');
}
public function create(Request $request)
{
     // Varidationを行う
     $this->validate($request, Profile::$rules);
     $news = new Profile;
     $form = $request->all();
    
     // フォームから送信されてきた_tokenを削除する
     unset($form['_token']);
     // フォームから送信されてきたimageを削除する
     unset($form['image']);
     
     // データベースに保存する
     $news->fill($form);
     $news->save();
     
     return redirect('admin/profile/create');
}
public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
    $posts = Profile::where('title', $cond_title)->get();
      } else {
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
public function edit(Request $request)
{
    $news = Profile::find($request->id);
      if (empty($news)) {
        abort(404);
      }
      return view('admin.profile.edit', ['news_form' => $news]);
}
public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Profile::$rules);
      // News Modelからデータを取得する
      $news = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      unset($news_form['remove']);
      unset($news_form['_token']);

      // 該当するデータを上書きして保存する
      $news->fill($news_form)->save();
      
      $history = new ProfileHistory;
        $history->profile_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

      return redirect('admin/profile');
}
public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $news = Profile::find($request->id);
      // 削除する
      $news->delete();
      return redirect('admin/profile/');
}
}