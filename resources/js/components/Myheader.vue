<template>
    
 <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Hamburger button -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#">
          <i class="fa fa-bars"></i>
        </a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    
    <ul class="navbar-nav ml-30" v-if="$gate.isUser()">
        <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" @click="clearNotify">
          <i class="fas fa-bell bell-css"></i>
          <span class="badge badge-warning navbar-badge">{{ this.count }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          
          <p v-if="notify == false">"no notification"</p>

          <a href="#" class="dropdown-item" v-for="n,key in notify">
            <p>order number #20011{{ n[1] }} is {{ n[2] }}</p>
            <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
  <!-- ./notification -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    
    </ul> 
  </nav>
  <!-- /.navbar -->

</template>

<script>
export default {
  data(){
    return{
      count: 0,
      notify: []
    }
  },
  methods:{

    clearNotify(){
      this.count = 0
    }
  },

  mounted(){
    
    Echo.private('pizza')
      .listen('OrderStatusChanged', (order) => {
          this.count += 1
          this.notify.push(order.obj)
          
      });
  }

}
</script>

<style>
.bell-css{
  font-size: 22px;
  margin-top: 5px;
}
</style>
