<template>
    <div class="container">
        <div class="row justify-content-center" v-if="!$gate.isAdmin()">            
                <not-found></not-found>
        </div>
        <div class="row justify-content-center" v-if="$gate.isAdmin()">
          <div class="col-10 mt-5 mb-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Table</h3>

                    <div class="card-tools" >
                        <button class="btn btn-info" style="color:#fff!important;" @click="openAdd" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="fa fa-user"></i>
                            Add User
                        </button>
                    </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th>Type</th>
                    <th>Modify</th>
                  </tr>
                  <!-- *** ignore this warning *** -->
                  <tr v-for="user,key in users">
                    <td>{{ user.name | capitalize }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.created_at | time-format }}</td>
                    <td><span class="badge bg-secondary">{{ user.type | capitalize }}</span></td>
                    
                    <td>
                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter2" @click="openUp(user.id,key)">
                            <i class="fa fa-edit" ></i>
                            Edit
                        </button> 
                        <button class="btn btn-warning" @click="del(user.id)">
                            <i class="fa fa-trash" ></i>
                            Delete
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
                <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadUser()"></pagination>
            </div>
            <!-- paginate -->
          </div>
          </div>
        <Add :openModal="addActive"></Add>
        <Update :openModal="addUpdate"></Update>
    </div>
</template>
<script>

// alert(window.user.type)

let Add = require('./AddUser.vue')
let Update = require('./UpdateUser.vue')
    export default {
        components:{Add,Update},
        data(){
            return{
                addActive: '',
                addUpdate: '',
                users:{},
                errors:{},
                pagination:{
                    'current_page': 1
                },
                
            }
        },
        methods:{
            // open add user modal
            openAdd(){
                this.addActive = 'exampleModalCenter'
                
            },
            // open update modal
            openUp(id,key){
                console.log(id)
                // push the users data belongs to specific key to user of specific children
                this.$children[1].user = this.users[key]      
                this.addUpdate = 'exampleModalCenter2'
                
            },
            // load User
            loadUser(){
                if (this.$gate.isAdmin()) {
                    
                    this.$Progress.start()
                    axios.get('api/user?page=' + this.pagination.current_page)
                    .then(response => {
    
                        this.users = response.data.data.data 
                        this.pagination = response.data.pagination;
                    })
                    .catch(
                        this.$Progress.fail()
                    )
                    this.$Progress.finish()
                }
            
               
            },
            close(){
                this.addActive = '';
            },
            // delete user
            del(id){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    axios.delete(`/api/user/${id}`)
                    .then(() => {
                         swal(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                        Fire.$emit('AfterAction')
                    })
                    .catch(() => {
                        swal("Failed!", "There was something wronge.", "warning");
                    })
                }
                })
            }
          
        },
        // load user when mounted
        created(){
         
            this.loadUser()
            // http request in every 1 minutes
            // setInterval(() => this.loadUser(),10000)
           
            
            // after any CRUD occurs call this
           
        }
        
    }
</script>


