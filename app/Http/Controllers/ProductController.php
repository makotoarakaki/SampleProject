<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Respons
     * e
     */

    public function index()
    {
        //$product = Product::all(); //Postのデータ全て$postsに代入(データ全件取得)
        // $product = Product::all();   // 全データ取得（古い順）
        // $product = Product::orderBy('created_at', 'desc')->get();//最新から表示する
        $product = \App\Product::orderBy('created_at', 'desc')->paginate(5);//最新から５件取得

        return view('admin.index', [
            "products" => $product
        ]);
        //return view('admin.index'); //view('ディレクトリ名.ファイル名');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        //
        // $product->image_url = $request->image_url->storeAs('public/images/products', $time.'_'.Auth::user()->id . '.jpg');
        return view('admin.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
        $product = new Product();

        $product->fill($request->all())->save();
        
        // $product->productName = $request->input('productName');
        // $product->productImage =$request->file('productImage')->getClientOriginalName();

        // // \Debugbar::info($request->file('productImage')->getClientOriginalName());

        // $product->productSubImage =$request->file('productSubImage')->getClientOriginalName();
        // $product->category =$request->input('category');
        // $product->explanation =$request->input('explanation');//説明
        // $product->remaining =$request->input('remaining');//残り
        // $product->amount =$request->input('amount');//価格
        // $product->save();

        // ここで画像を移動
        $request->file('productImage')->storeAs('public/products', $request->file('productImage')->getClientOriginalName());
        $request->file('productSubImage')->storeAs('public/products', $request->file('productSubImage')->getClientOriginalName());        

        return view('admin.detail')->with('product', $product);
    }

 
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */


    // public function show(Product $product)
    // {
    //     $product = Product::find($request->id);
    //     return view('admin.detail')->with('product', $product);
    // }

    public function show(Request $request)
    {
        $product = Product::findOrFail($request->id);
        return view('show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        return view('admin.edit', [
            'product' => Product::findOrFail($id)
          ]);

        //   \Debugbar::info(Product::findOrFail($id));          
    }

    // public function edit(Product $product)
    // {
    //     return view('admin.edit', compact('poroduct'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        // idを元にレコードを検索して$articleに代入
        $product = Product::find($request->id);
        // editで編集されたデータを$productにそれぞれ代入する
        // $product->productName = $request->productName;

        // $product->productImage = $request->file('productImage')->getClientOriginalName();
        // $product->productSubImage = $request->file('productSubImage')->getClientOriginalName();

        // $product->category = $request->category;
        // $product->explanation = $request->explanation;
        // $product->amount = $request->amount;


        // 保存
        // $product->save();
        // $product = Product::find($request->id);


        // 画像の制御処理
        $filename = '';
        if (is_null( $request->file('productImage') )) {
            $filename = $request->input('productImage_h');
        } else {
            //ファイル名を取得
            $filename = $request->file('productImage')->getClientOriginalName();
            // ファイルの保存
            $request->file('productImage')->storeAs('public/products',$filename);
        }

        $subfilename = '';
        if (is_null( $request->file('productSubImage') )) {
            $subfilename = $request->input('productSubImage_h');
        } else {
            //ファイル名を取得
            $subfilename = $request->file('productSubImage')->getClientOriginalName();
            // ファイルの保存
            $request->file('productSubImage')->storeAs('public/products', $subfilename);
        }


        $storedata =  array_replace($request->all(), array('productImage' => $filename),array('productSubImage' => $subfilename));
        // dd($storedata);
        $product->fill($storedata)->save();
        // \Debugbar::info($request->all());
        return view('admin.detail')->with('product', $product);
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Product $product)
    // {
    //     //
    // }
    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->id)->delete();
        // $product->delete();
        return redirect('admin/');
    }

}
