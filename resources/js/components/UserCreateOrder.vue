<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 mt-5 mb-5">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Place Order</a></li>
                  <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">My Orders</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                    <!-- Post -->
                    <h2 class="text-danger"></h2>
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control" disabled id="inputName" v-model="user.name" placeholder="Name"></div>
                      </div>
                      <div class="form-group">
                          <label for="inputState " class="col-sm-2 control-label">Size</label>
                          <div class="col-sm-10">
                            <select id="inputState2" v-model="order.size" class="form-control">
                                <option disabled>Choose...</option>
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="big">Big</option>
                            </select>
                          </div>
                          <small  class="text-danger"></small>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" v-model='order.address' rows="5" id="comment"></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Topping</label>
                        <div class="col-sm-10">
                        
                          <div class="checkbox">
                            <label><input type="checkbox" value="Cheese" v-model="order.topping">Cheese</label>
                          </div>
                          <div class="checkbox">
                            <label><input type="checkbox" value="Bacon" v-model="order.topping">Bacon</label>
                          </div>
                        </div>  
                      </div>
                     
                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="button" class="btn btn-success" @click="createOrder">Submit</button>
                        </div>
                      </div>

                      


                    </form>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  
                  <!-- tab 2 -->

                  <div class="tab-pane  active show" id="settings">
                    <table class="table table-hover table-bordered">
                  <tbody><tr>
                    <th>Order Number</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Size</th>
                    <th>Topping</th>
                    <th>Progress</th>
                    
                  </tr>

                  <tr v-for="o,key in orders">
                    <td>20011{{ key+1 }}</td>
                    <td>{{ o.address }}</td>
                    <td><span class="badge" :class="getColor(o.status)">{{ o.status }}</span></td>
                    <td>{{ o.size }}</td>
                    <td>{{ o.topping }}</td>
                    
                    
                    <td>
                       <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style=" {width: progress(o.status) + '%'}"></div>
                      </div>
                    </td>
                    

                    
                  </tr>
                  
                </tbody></table>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        </div>
    </div>
</template>

<script>
export default {
  data(){
    return{
      
      user:{},
      orders:{},
      order:{
        customer_id: user.id,
        customer_name: user.name,
        size:'',
        address:'',
        topping: [],
        status:'pending',
        progress: 15,
      },
    }
  },
  methods:{
    createOrder(){
      axios.post('orders',this.order)
      .then(response => {
        this.order = response.data
        this.orders.push(this.order)
        
      })
    },
    getUser(){
      axios.get('api/profile')
      .then(response =>{
          this.user = response.data
          return this.user
      }) 
    },
    getOrders(){
      axios.get('orders/getOrders')
      .then(response => {
        this.orders = response.data
        
      }) 
    },
    progress(status){
      if (status === 'pending') {
        return 15
      } else if(status === 'order placed') {
        return 50
      } else if(status === 'baking'){
        return 75
      } else if(status === 'delivered'){
        return 100
      } 
    },
    getColor(status){
      if (status === 'pending') {
        return 'bg-danger'
      } else if(status === 'order placed') {
        return 'bg-warning'
      } else if(status === 'baking'){
        return 'bg-warning'
      } else if(status === 'delivered'){
        return 'bg-success'
      } 
    }
    
  },
  mounted(){
    this.getUser()
    this.getOrders()
    // setInterval(() => this.getOrders(),30000)
    
     Echo.private('pizza')
      .listen('OrderStatusChanged', (order) => {
          var key = order.obj[0]         
          var status = order.obj[2]

          if (status === 'pending') {
            this.orders[key].progress = 15
          } else if(status === 'order placed') {
            this.orders[key].progress = 50
          } else if(status === 'baking'){
            this.orders[key].progress = 75
          } else if(status === 'delivered'){
            this.orders[key].progress = 100
          }      
          
          
          this.orders[order.obj[0]].status = status
          
          
      });
  }

}
</script>

<style>

</style>
