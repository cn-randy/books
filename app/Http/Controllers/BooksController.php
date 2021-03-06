<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class BooksController
 * @package App\Http\Controllers
 */
class BooksController
{
    /**
     * GET /books
     * @return array
     */
    public function index()
    {
            return Book::all();  
    }

    public function show(Request $request, $id)
    {
        try {
            return Book::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Book not found'
                ],
            ],  Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * POST /books
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
     public function store(Request $request)
    {
        $book = Book::create($request->all());

        return response()->json([
            'created' => true], 
            Response::HTTP_CREATED, [
            'Location' => route('books.show', ['id' => $book->id])
            ]);
    }

        /**
     * PUT /books/{id}
     *
     * @param Request $request
    * @param $id
    * @return mixed
    */
    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                'message' => 'Book not found'
            ]
            ], 404);
        }

        $book->fill($request->all());
        $book->save();
        return $book;
    }

    /**
     * DELETE /books/{id}
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Book not found'
                ]
            ], 404);
        }

        $book->delete();

        return response(null, 204);
    }
}
