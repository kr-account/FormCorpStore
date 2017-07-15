/**
 * Created by krishna on 15/7/17.
 */
Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

  el: '#manage-vue',

  data: {
    items: [],
    pagination: {
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1
      },
    offset: 4,
    formErrors:{},
    formErrorsUpdate:{},
    newItem : {
                  'id' : '',
                  'breed' : '',
                  'name' : '',
                  'age' : '',
                  'price' : '',
                  'list_date' : '',
                  'sale_date' : ''
                },
    fillItem : {
                  'id' : '',
                  'breed' : '',
                  'name' : '',
                  'age' : '',
                  'price' : '',
                  'list_date' : '',
                  'sale_date' : ''
                }
  },

  computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },

  ready : function(){
  		this.getVueItems(this.pagination.current_page);
  },

  methods : {

        getVueItems: function(page){
          this.$http.get('/petstore?page='+page).then((response) => {
            this.$set('items', response.data.data.data);
            this.$set('pagination', response.data.pagination);
        })
        },

        createItem: function(){
		  var input = this.newItem;
		  this.$http.post('/petstore',input).then((response) => {
		    this.changePage(this.pagination.current_page);

			this.newItem = {
              'id' : '',
              'breed' : '',
              'name' : '',
              'age' : '',
              'price' : '',
              'list_date' : '',
              'sale_date' : ''
            };

			$("#create-item").modal('hide');
			toastr.success('Item Created Successfully.', 'Success Alert', {timeOut: 5000});
		  }, (response) => {
			this.formErrors = response.data;
	    });
	},

      deleteItem: function(item){
        this.$http.delete('/petstore/'+item.id).then((response) => {
            this.changePage(this.pagination.current_page);
            toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        });
      },

      editItem: function(item){
          console.log(item);

          this.fillItem.id = item.id;
          this.fillItem.breed = item.breed;
          this.fillItem.name = item.name;
          this.fillItem.age = item.age;
          this.fillItem.price = item.price;
          this.fillItem.list_date = item.list_date;
          this.fillItem.sale_date = item.sale_date;

          $("#edit-item").modal('show');
      },

      updateItem: function(id){
        var input = this.fillItem;
        this.$http.put('/petstore/'+id,input).then((response) => {
            this.changePage(this.pagination.current_page);
            this.fillItem = {'title':'','description':'','id':''};
            $("#edit-item").modal('hide');
            toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
          }, (response) => {
              this.formErrorsUpdate = response.data;
          });
      },

      changePage: function (page) {
          this.pagination.current_page = page;
          this.getVueItems(page);
      }

  }

});