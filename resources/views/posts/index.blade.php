@extends('layouts.app')

@section('content')
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
          <input type="hidden" name="id" id="post_id">
          <!-- Name input -->
          <div class="form-outline mb-4">
            <input type="text" id="title" class="form-control" name="title" />
            <label class="form-label" for="form4Example1">Title</label>
          </div>

          <!-- Message input -->
          <div class="form-outline mb-4">
            <textarea class="form-control" id="form4Example3" rows="4" name="description" id="description"></textarea>
            <label class="form-label" for="form4Example3">Description</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="btnSubmit" class="btn btn-primary" value="Create">Add Post</button>
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
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float:right;" id="addnewpost">
    Add Post
  </button><br><br>
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
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
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
          name: 'action',
          orderable: false,
          searchable: false
        },
      ]
    });
    $("#addnewpost").click(function() {
      $("#post_id").val('');
      $("#createpost").trigger("reset");
      $("#exampleModal").modal('show');
    });
    $("#btnSubmit").click(function(e) {
      e.preventDefault();
      $(this).html('Save');
      $.ajax({
        data: $("#createpost").serialize(),
        url: "{{route('posts.store')}}",
        type: "POST",
        dataType: 'json',
        success: function(data) {
          $('#createpost').trigger("reset");
          $('#exampleModal').modal('hide');
          table.draw();
        },
        error: function(data) {
          console.log('Error:', data);
          $("#btnSubmit").html('Save');
        }
      });
    });
  });
</script>

@endsection