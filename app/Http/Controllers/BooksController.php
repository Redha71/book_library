<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Loans;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SebastianBergmann\Type\NullType;

class BooksController extends Controller
{
        /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Inertia\Response
     * view all book list
     */
    public function index()
    {
        $books=Books::leftJoin('loans','loans.book_id','=','books.id')->select(['books.*','loans.*'])->get();
        return response()->json([
            'books'=>$books
        ],200);
    }
    //Store in books and loans table the new book
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'author' => 'required|string',
            'publication_year' => 'required',
            'number_of_pages' => 'required',
        ]);
        $bookid =Books::insertGetId([
            'title' => $request->title,
            'author' => $request->author,
            'publication_year' => $request->publication_year,
            'number_of_pages' => $request->number_of_pages,
        ]);
        Loans::insert([
            'book_id'=>$bookid
        ]);
        $books=Books::leftJoin('loans','loans.book_id','=','books.id')->select(['books.*','loans.*'])->get();
        return response()->json([
            'books'=>$books
        ],200);
    }
// return the book using a herf link in book list
    public function returnBook($id)
    {
        Loans::where('book_id', $id) ->update([
            'loan_start_date' =>Null,
            'loan_end_date' => NULL
         ]);
         return redirect()->route('home');
    }
// borrowe book 
    public function borroweBook(Request $request)
    {
        Loans::where('book_id', $request->book_id) ->update([
            'loan_start_date' =>Carbon::now(),
            'loan_end_date' => Carbon::now()->addWeeks(2)
         ]);
         $books=Books::leftJoin('loans','loans.book_id','=','books.id')->select(['books.*','loans.*'])->get();
         return response()->json([
             'books'=>$books
         ],200);
    }
}
