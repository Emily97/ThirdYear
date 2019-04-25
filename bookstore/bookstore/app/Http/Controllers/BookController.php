<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return view('books.index')->with(array(
            'books' => $books
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
            'author' => 'required|max:191',
            'publisher' => 'required|max:191',
            'year' => 'required|integer|min:1900',
            'isbn' => 'required|alpha_num|size:13|unique:books',
            'price' => 'required|numeric|min:0'
        ]);

        $book = new Book();
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->publisher = $request->input('publisher');
        $book->year = $request->input('year');
        $book->isbn = $request->input('isbn');
        $book->price = $request->input('price');
        $book->save();

        $session = $request->session()->flash('message', 'Book added successfully!');

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);

        return view('books.show')->with(array(
            'book' => $book
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('books.edit')->with(array(
            'book' => $book
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|max:191',
            'author' => 'required|max:191',
            'publisher' => 'required|max:191',
            'year' => 'required|integer|min:1900',
            'isbn' => 'required|alpha_num|size:13|unique:books,isbn,' . $book->id,
            'price' => 'required|numeric|min:0'
        ]);

        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->publisher = $request->input('publisher');
        $book->year = $request->input('year');
        $book->isbn = $request->input('isbn');
        $book->price = $request->input('price');
        $book->save();

        $session = $request->session()->flash('message', 'Book updated successfully!');

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        Session::flash('message', 'Book deleted successfully!');

        return redirect()->route('books.index');
    }

    public function apiIndex()
    {
        $data = Book::all();
        $status = 200;
        $response = array(
            'status' => $status,
            'data' => $data
        );

        return response()->json($response);
    }

    public function apiShow($id)
    {
        $book = Book::find($id);
        if ($book === null) {
            $status = 404;
            $data = null;
        }
        else {
            $status = 200;
            $data = $book;
        }
        $response = array(
            'status' => $status,
            'data' => $data
        );

        return response()->json($response);
    }

    public function apiStore(Request $request)
    {
        $content = $request->getContent();
        $request->merge((array)json_decode($content));

        $rules = [
            'title' => 'required|max:191',
            'author' => 'required|max:191',
            'publisher' => 'required|max:191',
            'year' => 'required|integer|min:1900',
            'isbn' => 'required|alpha_num|size:13|unique:books',
            'price' => 'required|numeric|min:0'
        ];
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            $data = $validation->getMessageBag();
            $status = 422;
        }
        else {
            $book = new Book();
            $book->title = $request->input('title');
            $book->author = $request->input('author');
            $book->publisher = $request->input('publisher');
            $book->year = $request->input('year');
            $book->isbn = $request->input('isbn');
            $book->price = $request->input('price');
            $book->save();

            $data = $book;
            $status = 200;
        }

        $response = array(
            'status' => $status,
            'data' => $data
        );
        return response()->json($response);
    }
}
