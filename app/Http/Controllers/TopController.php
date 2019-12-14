<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;




class TopController extends Controller
{
    public function index()
    {

        //出力を戻り値に
        // return view('top');
        $product = Product::all();   // 全データ取得
        return view('top', [
            "products" => $product
        ]);
    
    }

    public function view()
    {
        $data = [
          'msg' => 'こんにちは、世界！'
        ];
        return view('hello.view', $data);
      }

      public function list()
      {
        $data = [
          'records' => Book::all()

          // 生のSQL
          // 'records' => DB::select('SELECT * FROM books')
        ];
        return view('hello.list', $data);
      }
}