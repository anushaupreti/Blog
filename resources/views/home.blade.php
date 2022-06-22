@extends('layouts.app')

@section('content')
<!-- <div class="alert alert-dismissible alert-success">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Well done!</strong> You've successfully added your post.
</div> -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary ms-5 m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add Post
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createpost" action="javascript:void(0)">
                    @csrf
                    <!-- Name input -->
                    <div class="form-outline mb-4">
                        <input type="text" id="title" class="form-control" name="title" />
                        <label class="form-label" for="form4Example1">Title</label>
                    </div>

                    <!-- Message input -->
                    <div class="form-outline mb-4">
                        <textarea class="form-control" id="form4Example3" rows="4" name="description"></textarea>
                        <label class="form-label" for="form4Example3">Description</label>
                    </div>

                    <!-- Submit button
                    <button type="submit" class="btn btn-primary btn-block mb-4">Send</button> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="btnsubmit" class="btn btn-primary">Add Post</button>
            </div>
        </div>
    </div>
</div>
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    {{ __('You are logged in! WELCOME to your Dashboard') }}
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="container">
    <h1>Post List</h1>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script type="text/javascript">
    var table = $(".data-table").DataTable({
        serverSide: true,
        processing: true,
        ajax: "{{route('posts.index')}}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'action',
                name: 'action'
            },
        ]
    });
</script>

@endsection