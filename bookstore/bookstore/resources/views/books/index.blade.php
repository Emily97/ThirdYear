@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (Session::has('message'))
            <p class="alert alert-success">{{ Session::get('message') }}</p>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">
                    Books

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modal-form">
                      Add
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('books.store') }}">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add new book</h4>
                              </div>
                              <div class="modal-body">
                                  <div class="form-group">
                                      <label for="title">Title</label>
                                      <input type="text" class="form-control" id="title" name="title" value="" />
                                      <span class="error" id="error-title"></span>
                                  </div>
                                  <div class="form-group">
                                      <label for="author">Author</label>
                                      <input type="text" class="form-control" id="author" name="author" value="" />
                                      <span class="error" id="error-author"></span>
                                  </div>
                                  <div class="form-group">
                                      <label for="publisher">Publisher</label>
                                      <input type="text" class="form-control" id="publisher" name="publisher" value="" />
                                      <span class="error" id="error-publisher"></span>
                                  </div>
                                  <div class="form-group">
                                      <label for="year">Year</label>
                                      <input type="number" class="form-control" id="year" name="year" value="" />
                                      <span class="error" id="error-year"></span>
                                  </div>
                                  <div class="form-group">
                                      <label for="isbn">ISBN</label>
                                      <input type="text" class="form-control" id="isbn" name="isbn" value="" />
                                      <span class="error" id="error-isbn"></span>
                                  </div>
                                  <div class="form-group">
                                      <label for="price">Price</label>
                                      <input type="number" class="form-control" id="price" name="price" value="" />
                                      <span class="error" id="error-price"></span>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="button" class="btn btn-primary" id="btn-submit">Submit</button>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="panel-body">
                    @if (count($books) === 0)
                        <p>There are no books!</p>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Year</th>
                                <th>ISBN</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                        @foreach ($books as $book)
                                <tr>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->publisher }}</td>
                                    <td>{{ $book->year }}</td>
                                    <td>{{ $book->isbn }}</td>
                                    <td>{{ $book->price }}</td>
                                    <td>
                                        <a href="{{ route('books.show', array('book' => $book)) }}"
                                           class="btn btn-default">View</a>
                                        <a href="{{ route('books.edit', array('book' => $book)) }}"
                                           class="btn btn-warning">Edit</a>
                                        <form style="display:inline-block" method="POST" action="{{ route('books.destroy', array('book' => $book)) }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="form-control btn btn-danger">Delete</a>
                                        </form>
                                   </td>
                                </tr>
                        @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
