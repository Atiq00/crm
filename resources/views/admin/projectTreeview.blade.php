<!DOCTYPE html>
<html>
<head>
	<title>Touchstone Client/Project Management</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="/css/treeview.css" rel="stylesheet">
</head>
<body>
	<div class="container">     
		<div class="panel panel-primary">
			<div class="panel-heading">Manage Project TreeView - <span class="adddata" style="float: right;cursor:pointer;">Add New</span></div>
	  		<div class="panel-body">
	  			<div class="row">
	  				<div class="col-md-6">
	  					<h3>Project List</h3>
				        <ul id="tree1">
				            @foreach($projects as $project)
				                <li>
				                    {{ $project->title }}
				                    @if(count($project->childs))
				                        @include('manageChild',['childs' => $project->childs])
				                    @endif
				                </li>
				            @endforeach
				        </ul>
	  				</div>
	  				<div class="col-md-6" id="add-project">
	  					<h3>Add New Project</h3>


				  			{!! Form::open(['route'=>'add.project']) !!}


				  				@if ($message = Session::get('success'))
									<div class="alert alert-success alert-block">
										<button type="button" class="close" data-dismiss="alert">×</button>	
									        <strong>{{ $message }}</strong>
									</div>
								@endif

								@if ($message = Session::get('error'))
									<div class="alert alert-danger alert-block">
										<button type="button" class="close" data-dismiss="alert">×</button>	
									        <strong>{{ $message }}</strong>
									</div>
								@endif
				  				<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
									{!! Form::label('Title:') !!}
									{!! Form::text('title', old('title'), ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
									<span class="text-danger">{{ $errors->first('title') }}</span>
								</div>

                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
									{!! Form::label('Code:') !!}
									{!! Form::text('code', old('code'), ['class'=>'form-control', 'placeholder'=>'Enter Code']) !!}
									<span class="text-danger">{{ $errors->first('code') }}</span>
								</div>

								<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
									{!! Form::label('Project:') !!}
									{!! Form::select('parent_id',$allProjects, old('parent_id'), ['class'=>'form-control', 'placeholder'=>'Select Project']) !!}
									<span class="text-danger">{{ $errors->first('parent_id') }}</span>
								</div>

								<div class="form-group">
									<button class="btn btn-success">Add New</button>
								</div>


				  			{!! Form::close() !!}


	  				</div>
	  				<div class="col-md-6" id="update-project" style="display:none;">
	  					<h3>Update Project</h3>


				  			{!! Form::open(['route'=>'update.project']) !!}


				  				@if ($message = Session::get('success'))
									<div class="alert alert-success alert-block">
										<button type="button" class="close" data-dismiss="alert">×</button>	
									        <strong>{{ $message }}</strong>
									</div>
								@endif


				  				<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
									{!! Form::label('Title:') !!}
									{!! Form::text('title', old('title'), ['class'=>'form-control', 'placeholder'=>'Enter Title', 'id'=>'title']) !!}
									<span class="text-danger">{{ $errors->first('title') }}</span>
								</div>

                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
									{!! Form::label('Code:') !!}
									{!! Form::text('code', old('code'), ['class'=>'form-control', 'placeholder'=>'Enter Code', 'id'=>'client_code']) !!}
									<span class="text-danger">{{ $errors->first('code') }}</span>
								</div>

								<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
									{!! Form::label('Project:') !!}
									{!! Form::select('parent_id',$allProjects, old('parent_id'), ['class'=>'form-control', 'placeholder'=>'Select Project', 'id'=>'project_code']) !!}
									<span class="text-danger">{{ $errors->first('parent_id') }}</span>
								</div>

								
								<input type="hidden" id="record_id" name="id" value="" />
								<div class="form-group">
									<button class="btn btn-success">Update</button>
								</div>


				  			{!! Form::close() !!}


	  				</div>

	  			</div>

	  			
	  		</div>
        </div>
    </div>
    <script src="/js/treeview.js"></script>
    <script type="text/javascript">
     
    $(document).ready(function () {
     
        /*------------------------------------------
        --------------------------------------------
        When click user on Show Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.updatedata', function () {
		  $('#add-project').hide();
		  $('#update-project').show();
          var code= $(this).attr('title'); 
          var userURL = 'http://127.0.0.1:8000/get-project/'+code;
 
            $.ajax({
                url: userURL,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('#title').val(response.data.title);
					$('#record_id').val(response.data.id);
                    $('#client_code').val(response.data.code);
                    $("#project_code").val(response.data.parent_id);
                    // $('#user-email').text(data.email);
                }
            });
 
       });
	   
	   $('body').on('click', '.adddata', function () {
		  $('#add-project').show();
		  $('#update-project').hide();
	   });

	   $('body').on('click', '.vertical', function () {
			var record_id= $(this).attr('title'); 
			var userURL = 'http://127.0.0.1:8000/get-child-projects/'+record_id;

            $.ajax({
                url: userURL,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                }
            });			
	   });
    });
   
</script>
</body>
</html>
