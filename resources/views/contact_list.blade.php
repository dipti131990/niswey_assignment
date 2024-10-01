@include('header')

<div class="container mt-3">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Contact List</h4>
          <div id="message"></div>   
          <table class="table">
            <thead>
              <tr>
                <th>Sr</th>
                <th>Name</th>
                <th>Last name</th>
                <th>Phone</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($list as $contact)
              <tr id="row_{{ $contact->id }}">
                <td>{{ $loop->iteration }}</td> 
                <td>{{ $contact->name }}</td> 
                <td>{{ $contact->last_name }}</td> 
                <td>{{ $contact->phone }}</td>
                <td><a href="javascript:void(0);"  onclick="return editContact({{ $contact->id }});"> Edit </a> - <a href="javascript:void(0);" onclick="return deleteContact({{ $contact->id }});">Delete</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- Display pagination links -->
          {{ $list->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title contact_action">Add Contact</h4>
          @if(session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif

          @if(session('error'))
              <div class="alert alert-danger">
                  {{ session('error') }}
              </div>
          @endif
          <form action="{{ route('contact.save') }}" method="POST">
              @csrf
              <div class="mb-3 mt-3">
                <label>Name</label>
                <input type="text" name="contactName" class="form-control" id="contactName" required>
              </div>
              <div class="mb-3 mt-3">
                <label>Last Name</label>
                <input type="text" name="contactLastname" class="form-control" id="contactLastname" required>
              </div>
              <div class="mb-3 mt-3">
                <label>phone</label>
                <input type="text" name="contactPhone" class="form-control" id="contactPhone" required>
              </div>
              <input type="hidden" id="contactId" name="contactId">
              <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div> 
  </div>
</div>
<script>
  function editContact(id){
    $('.contact_action').text('Update Contact');
    var contactName = $('#row_'+id).find('td:eq(1)').text();
    var contactLastname = $('#row_'+id).find('td:eq(2)').text();
    var contactPhone = $('#row_'+id).find('td:eq(3)').text();
    $('#contactName').val(contactName);
    $('#contactLastname').val(contactLastname);
    $('#contactPhone').val(contactPhone);
    $('#contactId').val(id);
    $('#contactName').focus();
  }
  function deleteContact(id) {
    var confirmDelete = confirm("Do you really want to delete this contact?");
    
    if (!confirmDelete) {
        return false;
    }

    $.ajax({
        url: "{{ url('delete_contact') }}", // Route to handle deletion
        type: 'POST',
        data: {
            id: id, 
            "_token": "{{ csrf_token() }}"
        },
        success: function(res) {
            if (res.status === 1) {
                // Show success message
                $('#message').html('<div class="alert alert-success">' + res.msg + '</div>');

                // Optionally, remove the deleted contact from the UI
                $('#row_' + id).remove();
            } else {
                // Show error message
                $('#message').html('<div class="alert alert-danger">' + res.msg + '</div>');
            }
        },
        error: function(res) {
            // Handle error response
            $('#message').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
        }
    });
}

</script>
@include('footer')
