<template>

<div class="modal fade"  :id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group col-md-12">
                    <label for="inputCity">Name</label>
                    <input type="text" class="form-control" id="inputCity" v-model="user.name">
                    <small v-if="errors.name" class="text-danger">*{{ errors.name[0] }}</small>

                </div>
               
                <div class="form-group col-md-12">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email" v-model="user.email">
                    <small v-if="errors.email" class="text-danger">*{{ errors.email[0] }}</small>
                </div>
                <div class="form-group col-md-12">
                    <label for="inputPassword4">Password</label>
                    <input type="password" class="form-control" id="inputPassword4" placeholder="Password" v-model="user.password">
                    <small v-if="errors.password" class="text-danger">*{{ errors.password[0] }}</small>
                </div>
                <div class="form-group col-md-12">
                    <label for="inputState">Type</label>
                    <select id="inputState" class="form-control" v-model="user.type">
                        <option selected>Choose...</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="author">Author</option>
                    </select>
                    <small v-if="errors.type" class="text-danger">*{{ errors.type[0] }}</small>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"   @click="close">Close</button>
            <button type="button" class="btn btn-primary" @click="save">Save changes</button>
        </div>
        </div>
  </div>
</div>
</template>

<script>
export default {
    props:['openModal'],
    data(){
        return{
            user:{
                name:'',
                email:'',
                password:'',
                type:''
            },
            errors:{}
        }
    },
    methods:{
         close(){
            //  reset previously inputted data and errors
            this.user = {
                    name:'',
                    email:'',
                    password:'',
                    type:''
                }
            this.errors = ''
        },
        save(){
            axios.post('api/user',this.user)
            .then((response)=>{

                this.user = response.data;
                //pushing data to home users from user here
                this.$parent.users.push(this.user)
                
                // reset the data fields of user
                this.user = {
                    name:'',
                    email:'',
                    password:'',
                    type:''
                }

                toast({
                    type: 'success',
                    title: 'New user added successfully'
                })

                Fire.$emit('AfterAction')
  
            })
            .catch((error) => this.errors = error.response.data.errors) 
           
        }
       
    }
}
</script>

<style>

</style>
