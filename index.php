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
    </style>
    <script src="bower_components/vue/dist/vue.min.js"></script>
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

    <script type="text/javascript">
	     new Vue({
	     	el: '#app',
	     	data: {
     			addData: true,
     			id: '',
     			name: '',
     			age: '',
     			gender: '',
     			address: '',
     			data : [],
     			temp: [],
     			search: ''
	     	},
	     	created() {
	     		this.fetchData();
	     	},
	     	methods: {
	     		fetchData(){
	     			vm = this
	     			$.get('fetch.php', function(data, status){
	     				result = JSON.parse(data);
	     				vm.data = result;
	     			});
	     		},
	     		addNewData(){
	     			vm = this
	     			data = {
	     				name: this.name,
	     				age: this.age,
	     				gender: this.gender,
	     				address: this.address,
	     				action: 'addNewData'
	     			}
	     			$('#addDataButton').addClass('loading-cube lighten').text('LOADING...')
				   	$.post('create.php', data , function(data, status){
				    	result = JSON.parse(data)
				    	if (result.result === 'success') {
							$.Notify({
							    caption: 'INFO ALERT',
							    content: result.message,
							    type: 'success'
							});
					    	vm.name = vm.age = vm.gender = vm.address = ''
					    	vm.data.push(JSON.parse(result.data))
					    	$('#addDataButton').removeClass('loading-cube lighten').text('ADD NEW DATA')
				    	} else {
							$.Notify({
							    caption: 'INFO ALERT',
							    content: result.message,
							    type: 'alert'
							});
				    		$('#addDataButton').removeClass('loading-cube lighten').text('ADD NEW DATA')
				    	}
				    })
	     		},
	     		editData(data) {
	     			vm = this
	     			vm.addData = false
	     			vm.id = data.id
     				vm.name = data.name
     				vm.age = data.age
     				vm.gender = data.gender
     				vm.address = data.address
     				vm.temp = data
	     		},
	     		cancelEdit() {
	     			vm = this
	     			vm.addData = true
	     			vm.temp = []
	     			vm.id = vm.name = vm.age = vm.gender = vm.address = ''
	     		},
	     		updateData(){
	     			vm = this
	     			data = {
	     				id: this.id,
	     				name: this.name,
	     				age: this.age,
	     				gender: this.gender,
	     				address: this.address,
	     				action: 'updateData'
	     			}
	     			$('#updateDataButton').addClass('loading-cube lighten').text('LOADING...')
				   	$.post('update.php', data , function(data, status){
				    	result = JSON.parse(data)
				    	if (result.result === 'success') {
							$.Notify({
							    caption: 'INFO ALERT',
							    content: result.message,
							    type: 'success'
							});
							index = vm.data.indexOf(vm.temp)
							vm.data[index] = JSON.parse(result.data)
			     			vm.addData = true
			     			vm.temp = []
			     			vm.id = vm.name = vm.age = vm.gender = vm.address = ''
			     			$('#updateDataButton').removeClass('loading-cube lighten').text('UPDATE DATA')
				    	} else {
				    		$('#updateDataButton').removeClass('loading-cube lighten').text('UPDATE DATA')
				    	}
				    })
	     		},
	     		searchData() {
	     			vm = this
	     			$.get('search.php?q='+vm.search, function(data, status){
	     				if (data) {
		     				result = JSON.parse(data)
		     				vm.data = result
	     				} else {
	     					vm.data = []
	     				}
	     			})
	     		},
	     		deleteData(data) {
	     			vm = this
	     			vm.addData = true
					metroDialog.create({
					    title: "Delete Data",
					    content: "Are you sure you want to delete this data?",
					    actions: [
					        {
					            title: "Yes",
					            onclick: function(el){
					                $(el).data('dialog').close();
					     			$.get('delete.php?id='+data.id, function(data, status){
					     				result = JSON.parse(data);
										$.Notify({
										    caption: 'INFO ALERT',
										    content: result.message,
										    type: 'success'
										});
					     				index = vm.data.indexOf(data)
					     				vm.data.splice(index)
					     			})
					            }
					        },
					        {
					            title: "Cancel",
					            cls: "js-dialog-close"
					        }
					    ],
					    options: {
					    }
					});
	     		}
	     	}
	     })
    </script>
</body>
</html>