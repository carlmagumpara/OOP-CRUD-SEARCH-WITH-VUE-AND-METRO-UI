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
		search: '',
		pagination: true,
		page: 0
	},
	created() {
		this.fetchData();
	},
	methods: {
		fetchData(){
			vm = this
			$.get('fetch.php?users=' + vm.page, function(data, status){
				result = JSON.parse(data)
				vm.data = result;
			});
		},
		addNewData(){
			vm = this
			data = {
				name: this.name,
				age: this.age,
				gender: this.gender,
				address: this.address
			}
			$('#addDataButton').addClass('loading-cube lighten').text('LOADING...')
		   	$.post('create.php', data , function(data, status){
		    	result = JSON.parse(data)
		    	if (result.result === 'success') {
					$.Notify({
					    caption: 'SUCCESS',
					    content: result.message,
					    type: 'success'
					});
			    	vm.name = vm.age = vm.gender = vm.address = ''
			    	vm.page = 0
			    	vm.fetchData()
			    	$('#addDataButton').removeClass('loading-cube lighten').text('ADD NEW DATA')
		    	} else {
					$.Notify({
					    caption: 'ERROR',
					    content: vm.listErrors(result.response),
					    type: 'alert'
					});
		    		$('#addDataButton').removeClass('loading-cube lighten').text('ADD NEW DATA')
		    	}
		    })
		},
		listErrors(data){
			result = JSON.parse(JSON.parse(data))
			var li = ''
			for (var i = 0; i < result.length; i++) {
				 li += '<li>'+result[i]+'</li>'
			}
			return '<ul class="unlist-style no-padding">'+li+'</ul>'
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
				address: this.address
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
					vm.data[index] = JSON.parse(result.response)
	     			vm.addData = true
	     			vm.temp = []
	     			vm.id = vm.name = vm.age = vm.gender = vm.address = ''
	     			$('#updateDataButton').removeClass('loading-cube lighten').text('UPDATE DATA')
		    	} else {
					$.Notify({
					    caption: 'ERROR',
					    content: vm.listErrors(result.response),
					    type: 'alert'
					});
		    		$('#updateDataButton').removeClass('loading-cube lighten').text('UPDATE DATA')
		    	}
		    })
		},
		searchData() {
			vm = this
			if (vm.search) {
				$.get('search.php?q='+vm.search, function(data, status){
 					result = JSON.parse(data)
 					vm.data = result
				})
				vm.pagination = false			
			} else {
				vm.fetchData()
				vm.pagination = true
			}
			vm.page = 0
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
								vm.fetchData()
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
		},
	    nextPage(){
	    	vm = this
	    	vm.page = vm.page + 5
			$.get('fetch.php?users=' + vm.page, function(data, status){
				result = JSON.parse(data)
				vm.data = result;
			});
	    },
	    prevPage(){
	    	vm = this
	    	vm.page = vm.page - 5
			$.get('fetch.php?users=' + vm.page, function(data, status){
				result = JSON.parse(data)
				vm.data = result;
			});
	    }
	}
})