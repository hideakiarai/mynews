<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// // 以下を追記することでNews Modelが扱えるようになる
// use App\News;
​
class NewsController extends Controller
{
  public function add()
  {
      return view('admin.news.create');
  }
// ​
//   public function create(Request $request)
//   {
// ​    return redirect('admin/news/create');
//   }  

}