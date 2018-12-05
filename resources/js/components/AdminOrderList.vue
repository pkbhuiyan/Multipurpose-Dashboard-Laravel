<template>
    <div class="container">
        <div class="row justify-content-center" v-if="!$gate.isAdmin()">            
                <not-found></not-found>
        </div>
        <div class="row justify-content-center" v-if="$gate.isAdmin()">
          <div class="col-10 mt-5 mb-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Orders List Table</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered">
                  <tbody><tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Size</th>
                    <th>Topping</th>
                   
                    <th>Action</th>
                  </tr>

                  <tr v-for="o,key in orders">
                    <!-- <td>{{ key }}</td> -->
                    <td>{{ o.customerName }}</td>
                    <td>{{ o.address }}</td>
                    <td>
                      <form>
                        <div class="form-group">
                          <select id="inputState" class="form-control" v-model="o.status">
                              <option selected>Choose...</option>
                              <option value="pending">Pending</option>
                              <option value="order placed">Order Placed</option>
                              <option value="baking">Baking</option>
                              <option value="delivered">Delivered</option>
                          </select>
                          <small class="text-danger"></small>
                        </div>
                      </form>
                    </td>
                    <td>{{ o.size }}</td>
                    <td>{{ o.topping }}</td>
                    
                    
                    <td>
                        <button class="btn btn-success" @click="updateStatus(o.orderid,key)" type="button">
                            <i class="fa fa-edit" ></i>
                            Update
                        </button>   
                    </td>
                  
                    
                  </tr>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>

            <!-- /.card -->
            <!-- paginate -->
            <div class="paginate">
                <!-- <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadUser()"></pagination> -->
            </div>
            <!-- paginate -->
          </div>
          </div>
    </div>
</template>

<script>
export default {
  data(){
    return{
      orders:{},
      orderUp:{}
    }
  },
  methods:{
    
    getOrders(){
      axios.get('orders/getOrders')
      .then(response => {
        this.orders = response.data
        
      }) 
    },
    updateStatus(id,key){
      console.log(key);
      this.orderUp = this.orders[key]
      this.orderUp.key = key
      console.log(this.orderUp);
      
      axios.put(`/orders/${id}`,this.orderUp)
      .then(
        
       
      )
    }
  },
  mounted(){
    this.getOrders()
  }

}
</script>

<style>

</style>
