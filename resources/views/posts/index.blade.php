@extends('layouts.app')

@section('content' )
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createpost" action="javascript:void(0)">
          <input type="hidden" name="post_id" id="post_id">
          <!-- Name input -->
          <div class="form-outline mb-4">
            <input type="text" id="title" class="form-control" name="title" placeholder="Enter Title..." required />
            <label class="form-label" for="title">Title</label>
          </div>

          <!-- Message input -->
          <div class="form-outline mb-4">
            <textarea class="form-control" id="description" rows="4" name="description" placeholder="Enter description..." required></textarea>
            <label class="form-label" for="description">Description</label>
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
<div class="container">
  <h1>Post List</h1>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float:right;" id="addnewpost" href="javascript:void(0)">
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
  });
</script>
<script type="text/javascript">
  $(function() {
    $("#addnewpost").click(function() {
      $("#exampleModalLabel").html("Add New Post");
      $("#post_id").val('');
      $("#createpost").trigger("reset");
      $("#exampleModal").modal('show');
    });

    $('#btnSubmit').click(function(e) {
      e.preventDefault();
      $.ajax({
        data: $('#createpost').serialize(),
        url: "{{url('posts')}}",
        type: "POST",
        dataType: 'json',
        success: function(data) {
          $("#createpost").trigger("reset");
          $('#exampleModal').modal('hide');
          table.draw();
        },
        error: function(data) {
          console.log(data);
          $("#btnSubmit").html('save');
        }
      });
    });

    $('body').on('click', '.deletePost', function() {
      var post_id = $(this).data("id");
      confirm("Are you sure want to delete??");
      $.ajax({
        type: "DELETE",
        url: "{{route('posts.store')}}" + '/' + post_id,
        success: function(data) {
          table.draw();
        },
        error: function(xhr) {
          console.log('Error:', data);
        }
      });
    });
    $('body').on('click', '.editPost', function() {
      var post_id = $(this).data('id');
      $.get("{{route('posts.index')}}" + "/" + post_id + "/edit", function(data) {
        $("#exampleModalLabel").html("Edit Post");
        $('#exampleModal').modal('show');
        $("#post_id").val(data.id);
        $("#title").val(data.title);
        $("#description").val(data.description);
      });
    });
  });
</script>


@endsection