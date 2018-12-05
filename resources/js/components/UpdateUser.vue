<template>
    <div class="modal fade"  :id="openModal"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                    <input type="text" class="form-control" id="inputCity1" v-model="user.name" required>
                    <small v-if="errors.name" class="text-danger">*{{ errors.name[0] }}</small>
                </div>
               
                <div class="form-group col-md-12">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail41" placeholder="Email" v-model="user.email" required>
                    <small v-if="errors.email" class="text-danger">*{{ errors.email[0] }}</small>
                </div>
  
                <div class="form-group col-md-12">
                    <label for="inputState">Type</label>
                    <select id="inputState2" class="form-control" v-model="user.type" >
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
            <button type="button" class="btn btn-primary" @click="updateUser(user.id)">Save changes</button>
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
                user:{},
                errors:{}
            }
        },
        methods:{
            updateUser(id){
                if (id) {
                    axios.put(`/api/user/${id}`,this.$data.user)
                       .then( (response) => {
                               
                            this.errors = {}
                            toast({
                                type: 'success',
                                title: 'User Updated'
                            })

                            Fire.$emit('AfterAction')
                            Reload.$emit('AfterSubmit')
                       })
                       .catch((error) => this.errors = error.response.data.errors)
                }
                    
                
                
                
            }
        }

    }
</script>
