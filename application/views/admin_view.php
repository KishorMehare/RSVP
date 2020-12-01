<html>
<head>
    <title>Admin | Participants</title>


    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
   <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
	     <link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <style>
		table.dataTable thead .sorting:after,
		table.dataTable thead .sorting:before,
		table.dataTable thead .sorting_asc:after,
		table.dataTable thead .sorting_asc:before,
		table.dataTable thead .sorting_asc_disabled:after,
		table.dataTable thead .sorting_asc_disabled:before,
		table.dataTable thead .sorting_desc:after,
		table.dataTable thead .sorting_desc:before,
		table.dataTable thead .sorting_desc_disabled:after,
		table.dataTable thead .sorting_desc_disabled:before {
		  bottom: .5em;
		}
	</style>
</head>
<body>
    <div class="container">
        <br />
        <h3 align="center">Admin</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">Participants</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Add</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
				<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
				  <thead>
					<tr>
						<th class="th-sm" >Name</th>
						<th class="th-sm" >Age</th>
						<th class="th-sm" >DOB</th>
						<th class="th-sm" >Profession</th>
						<th class="th-sm" >Locality</th>
						
						<th class="th-sm" >No.Of.Guest</th>
						<th class="th-sm">Address</th>
						<th class="th-sm" >Edit</th>
						<th class="th-sm" >Delete</th>
					</tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Participants</h4>
                </div>
                <div class="modal-body">
                    <label>Enter Name</label>
                    <input type="text" name="name" id="name" class="form-control" />
                    <span id="name_error" class="text-danger"></span>
                    <br />
                    <label>Enter Age</label>
                    <input type="number" name="age" id="age" class="form-control" />
                    <span id="age_error" class="text-danger"></span>
                    <br />
					<label>Enter DOB</label>
                    <input type="text" name="dob" id="dob" class="form-control" data-provide="datepicker" />
                    
					
					<span id="dob_error" class="text-danger"></span>
                    <br />
					<label>Enter locality</label>
                    <input type="text" name="locality" id="locality" class="form-control" />
                    <span id="locality_error" class="text-danger"></span>
                    <br />
					<label>Enter Profession</label>
                    <input type="text" name="profession" id="profession" class="form-control" />
                    <span id="profession_error" class="text-danger"></span>
                    <br />
					<label>Enter No.Of.Guest</label>
                    <input type="number" name="no_of_guest" id="no_of_guest" class="form-control" />
                    <span id="no_of_guest_error" class="text-danger"></span>
                    <br />
					<label>Enter Address</label>
                    <textarea type="text" name="address" id="address" class="form-control" ></textarea>
                    <span id="address_error" class="text-danger"></span>
                    <br />
					
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="user_id" />
                    <input type="hidden" name="data_action" id="data_action" value="Insert" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
 <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" language="javascript" >
/* $(document).ready(function () {
	$('#dtBasicExample').DataTable();
	$('.dataTables_length').addClass('bs-select');
}); */

$(document).ready(function(){
    // Data Picker Initialization
$('.datepicker').datepicker();

    function fetch_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>admin_api/action",
            method:"POST",
            data:{data_action:'fetch_all'},
            success:function(data)
            {
                $('tbody').html(data);
            }
        });
    }

    fetch_data();

    $('#add_button').click(function(){
        $('#user_form')[0].reset();
        $('.modal-title').text("Add Participants");
        $('#action').val('Add');
        $('#data_action').val("Insert");
        $('#userModal').modal('show');
    });

    $(document).on('submit', '#user_form', function(event){
        event.preventDefault();
        $.ajax({
            url:"<?php echo base_url() . 'admin_api/action' ?>",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                if(data.success)
                {
                    $('#user_form')[0].reset();
                    $('#userModal').modal('hide');
                    fetch_data();
                    if($('#data_action').val() == "Insert")
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Inserted</div>');
                    }
                }

                if(data.error)
                {
                    $('#name_error').html(data.name_error);
                    $('#last_name_error').html(data.last_name_error);
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var user_id = $(this).attr('id');
        $.ajax({
            url:"<?php echo base_url(); ?>admin_api/action",
            method:"POST",
            data:{id:user_id, data_action:'fetch_single'},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#name').val(data.name);
                $('#age').val(data.age);
                $('#dob').val(data.dob);
                $('#locality').val(data.locality);
                $('#profession').val(data.profession);
                $('#address').val(data.address);
                $('.modal-title').text('Edit Participants');
                $('#user_id').val(user_id);
                $('#action').val('Edit');
                $('#data_action').val('Edit');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var user_id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?"))
        {
            $.ajax({
                url:"<?php echo base_url(); ?>admin_api/action",
                method:"POST",
                data:{id:user_id, data_action:'Delete'},
                dataType:"JSON",
                success:function(data)
                {
                    if(data.success)
                    {
                        $('#success_message').html('<div class="alert alert-success">Participants Deleted</div>');
                        fetch_data();
                    }
                }
            })
        }
    });
    
});
$(document).ready(function() {
    $('#dtBasicExample').DataTable();
} );

$(document).ready(function() {
    // Setup - add a text input to each footer cell
    /* $('#dtBasicExample tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } ); */
 
    // DataTable
	/* var table = $('#dtBasicExample').DataTable(); */
   /*  var table = $('#dtBasicExample').DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    }); */
 
} );
</script>