<!DOCTYPE html>
<html>
<head>
    <link href="css/metro.min.css" rel="stylesheet">
 	<link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.min.css" rel="stylesheet">
    <link href="css/metro-responsive.min.css" rel="stylesheet">
    <link href="css/metro-schemes.min.css" rel="stylesheet">
    <style type="text/css">
    	.wrapper {
    		margin-top: 50px;
    	}
    	.unlist-style {
    		list-style: none;
    	}
    	.no-padding {
    		padding: 0px;
    		margin: 0px;
    	}
    </style>
    <script src="bower_components/vue/dist/vue.min.js"></script>
    <script src="js/vue-resource.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vuejs-paginator/2.0.0/vuejs-paginator.js"></script>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="js/metro.min.js"></script>
</head>
<body>
	<div class="wrapper" id="app">
		<div class="flex-grid">
			<div class="row flex-just-center">
	            <div class="cell size9">
	            	<form @submit.prevent="searchData">
						<label>SEARCH DATA</label>
						<div class="input-control text full-size" data-role="input">
						    <input type="text" v-model="search" @keyup.prevent="searchData" placeholder="Search from names..">
						    <button class="button" type="submit"><span class="mif-search"></span></button>
						</div>
	            	</form>
					<table class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Age</th>
								<th>Gender</th>
								<th>Address</th>
								<th style="width: 150px;">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="data in data">
								<td>{{ data.id }}</td>
								<td>{{ data.name }}</td>
								<td>{{ data.age }}</td>
								<td>{{ data.gender == 1 ? 'Male' : 'Female' }}</td>
								<td>{{ data.address }}</td>
								<td>
									<button class="button danger small-button" @click.prevent="deleteData(data)">Delete</button>
									<button class="button info small-button" @click.prevent="editData(data)">Edit</button>
								</td>
							</tr>
							<tr v-if="data.length === 0">
								<td colspan="6" style="text-align: center;">No Record Found</td>
							</tr>
						</tbody>
					</table>
					<div v-if="pagination">
						<button class="button primary" id="next" @click.prevent="nextPage" v-if="data.length >= 5">NEXT</button>
						<button class="button primary" id="prev" @click.prevent="prevPage"  v-if="page != 0">PREV</button>
						<span>Page {{ page }} to {{ page + 5 }} </span>			
					</div>
	            </div>
	         </div>
	        <div class="row flex-just-center">
	            <div class="cell size9">
					<form @submit.prevent="addNewData" v-if="addData">
						<label>ADD NEW DATA</label>
						<div class="input-control text full-size">
						    <input type="text" placeholder="Name" v-model="name">
						</div>
						<div class="input-control text full-size">
						    <input type="text" placeholder="Age" v-model="age">
						</div>
						<label class="input-control radio">
						    <input type="radio" name="gender" value="1" v-model="gender">
						    <span class="check"></span>
						    <span class="caption">Male</span>
						</label>
						<label class="input-control radio">
						    <input type="radio" name="gender" value="0" v-model="gender">
						    <span class="check"></span>
						    <span class="caption">Female</span>
						</label>
						<div class="input-control text full-size">
						    <input type="text" placeholder="Address" v-model="address">
						</div>
						<button class="button primary full-size" id="addDataButton">ADD NEW DATA</button>
					</form>
					<form @submit.prevent="editData" v-else>
						<label>UPDATE DATA</label>
						<input type="hidden" v-model="id">
						<div class="input-control text full-size">
						    <input type="text" placeholder="Name" v-model="name">
						</div>
						<div class="input-control text full-size">
						    <input type="text" placeholder="Age" v-model="age">
						</div>
						<label class="input-control radio">
						    <input type="radio" name="gender" value="1" v-model="gender">
						    <span class="check"></span>
						    <span class="caption">Male</span>
						</label>
						<label class="input-control radio">
						    <input type="radio" name="gender" value="0" v-model="gender">
						    <span class="check"></span>
						    <span class="caption">Female</span>
						</label>
						<div class="input-control text full-size">
						    <input type="text" placeholder="Address" v-model="address">
						</div>
						<button class="button primary full-size" id="updateDataButton" @click.prevent="updateData">UPDATE DATA</button>
						<button class="button full-size" @click.prevent="cancelEdit">CANCEL</button>
					</form>
	            </div>
	        </div>			
		</div>
	</div>
    <script src="index.js"></script>
</body>
</html>