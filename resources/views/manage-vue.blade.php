<!DOCTYPE html>
<html>
<head>
	<title>Rescued Pets Store</title>
	<meta id="token" name="token" value="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css">
</head>
<body>

	<div class="container" id="manage-vue">

		<div class="row">
		    <div class="col-lg-12 margin-tb">
		        <div class="pull-left">
		            <h2>Rescued Pets Store</h2>
		        </div>
		        <div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
				  Create Item
				</button>
		        </div>
		    </div>
		</div>

		<!-- Item Listing -->
		<table class="table table-bordered">
			<tr>
				<th>Breed</th>
				<th>Name</th>
				<th>Age</th>
				<th>Price</th>
				<th>List Date</th>
				<th>Sale Date</th>
				<th width="200px">Action</th>
			</tr>
			<tr v-for="item in items">
				<td>@{{ item.breed }}</td>
				<td>@{{ item.name }}</td>
				<td>@{{ item.age }}</td>
				<td>@{{ item.price }}</td>
				<td>@{{ item.list_date }}</td>
				<td>@{{ item.sale_date }}</td>
				<td>
			      <button class="btn btn-primary" @click.prevent="editItem(item)">Edit</button>
			      <button class="btn btn-danger" @click.prevent="deleteItem(item)">Delete</button>
				</td>
			</tr>
		</table>

		<!-- Pagination -->
		<nav>
	        <ul class="pagination">
	            <li v-if="pagination.current_page > 1">
	                <a href="#" aria-label="Previous"
	                   @click.prevent="changePage(pagination.current_page - 1)">
	                    <span aria-hidden="true">«</span>
	                </a>
	            </li>
	            <li v-for="page in pagesNumber"
	                v-bind:class="[ page == isActived ? 'active' : '']">
	                <a href="#"
	                   @click.prevent="changePage(page)">@{{ page }}</a>
	            </li>
	            <li v-if="pagination.current_page < pagination.last_page">
	                <a href="#" aria-label="Next"
	                   @click.prevent="changePage(pagination.current_page + 1)">
	                    <span aria-hidden="true">»</span>
	                </a>
	            </li>
	        </ul>
	    </nav>

	    <!-- Create Item Modal -->
		<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Create Item</h4>
		      </div>
		      <div class="modal-body">

		      		<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">

		      			<div class="form-group">
                            <label for="title">Breed:</label>
                            <input type="text" name="breed" class="form-control" v-model="newItem.breed" />
                            <span v-if="formErrors['breed']" class="error text-danger">@{{ formErrors['breed'] }}</span>
						</div>

						<div class="form-group">
							<label for="title">Name:</label>
							<input type="text" name="name" class="form-control" v-model="newItem.name" />
							<span v-if="formErrors['name']" class="error text-danger">@{{ formErrors['name'] }}</span>
						</div>

 						<div class="form-group">
							<label for="title">Age:</label>
							<input type="text" name="age" class="form-control" v-model="newItem.age" />
							<span v-if="formErrors['age']" class="error text-danger">@{{ formErrors['age'] }}</span>
						</div>

  						<div class="form-group">
							<label for="title">Price:</label>
							<input type="text" name="price" class="form-control" v-model="newItem.price" />
							<span v-if="formErrors['price']" class="error text-danger">@{{ formErrors['price'] }}</span>
						</div>

  						<div class="form-group">
							<label for="title">List Date:</label>
							<input type="text" name="list_date" value="{{date('Y-m-d H:i:s')}}" class="form-control" v-model="newItem.list_date" />
							<span v-if="formErrors['list_date']" class="error text-danger">@{{ formErrors['list_date'] }}</span>
						</div>

  						<div class="form-group">
							<label for="title">Sale Date:</label>
							<input type="text" name="sale_date" class="form-control" v-model="newItem.sale_date" />
							<span v-if="formErrors['sale_date']" class="error text-danger">@{{ formErrors['sale_date'] }}</span>
						</div>

					<div class="form-group">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>

		      		</form>


		      </div>
		    </div>
		  </div>
		</div>

		<!-- Edit Item Modal -->
		<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
		      </div>
		      <div class="modal-body">

		      		<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">

		      		<div class="form-group">
						<label for="title">Breed:</label>
						<input type="text" name="breed" class="form-control" v-model="fillItem.breed">
						<span v-if="formErrorsUpdate['breed']" class="error text-danger">@{{ formErrorsUpdate['breed'] }}</span>
					</div>

					<div class="form-group">
						<label for="title">Name:</label>
						<input type="text" name="name" class="form-control" v-model="fillItem.name"/>
						<span v-if="formErrorsUpdate['name']" class="error text-danger">@{{ formErrorsUpdate['name'] }}</span>
					</div>

                    <div class="form-group">
                        <label for="title">Age:</label>
                        <input type="text" name="age" class="form-control" v-model="fillItem.age">
                        <span v-if="formErrorsUpdate['age']" class="error text-danger">@{{ formErrorsUpdate['age'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="title">Price:</label>
                        <input type="text" name="price" class="form-control" v-model="fillItem.price">
                        <span v-if="formErrorsUpdate['price']" class="error text-danger">@{{ formErrorsUpdate['price'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="title">List Date:</label>
                        <input type="text" name="list_date" class="form-control" v-model="fillItem.list_date">
                        <span v-if="formErrorsUpdate['list_date']" class="error text-danger">@{{ formErrorsUpdate['list_date'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="title">Sale Date Date:</label>
                        <input type="text" name="sale_date" class="form-control" v-model="fillItem.sale_date">
                        <span v-if="formErrorsUpdate['sale_date']" class="error text-danger">@{{ formErrorsUpdate['sale_date'] }}</span>
                    </div>


					<div class="form-group">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>

		      		</form>

		      </div>
		    </div>
		  </div>
		</div>

	</div>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/vue.resource/0.9.3/vue-resource.min.js"></script>

	<script src="{{asset('assets/pets.js')}}" type="text/javascript"></script>

</body>
</html>
