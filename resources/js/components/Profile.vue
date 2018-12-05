<template>
    <div class="container">
        <div class="row justify-content-center">
            <!-- profile card -->
            <div class="col-md-10 mt-5">
                <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background:url('./image/background-user.png') center center;">
                <h3 class="widget-user-username">{{user.name}}</h3>
                <h5 class="widget-user-desc">{{user.type}}</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" :src="getProfilePicture()" alt="User Avatar">
                
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            </div>
            <!-- profile card end -->
            <!-- user settings -->
            <div class="col-md-10">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Change Password</a></li>
                  <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Profile</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                    <!-- Post -->
                    <h2 class="text-danger" v-if="message">{{ message }}</h2>
                    <form class="form-horizontal">


                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Old Password</label>

                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="inputOldPass" placeholder="Old Password" v-model="user.current_password" required>
                           <small v-if="errors.current_password" class="text-danger">*{{ errors.current_password[0] }}</small>
                         
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">New Password</label>

                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="inputNewPass" placeholder="New Password" v-model="user.new_password" required>
                            <small v-if="errors.new_password" class="text-danger">*{{ errors.new_password[0] }}</small>
                      
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success" @click.prevent="changePassword">Reset Password</button>
                        </div>
                      </div>


                    </form>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  


                  <div class="tab-pane  active show" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" placeholder="Name" v-model="user.name"></div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10">
                          <input type="email" v-model="user.email" class="form-control" id="inputEmail" placeholder="Email">
                          <small v-if="errors.email" class="text-danger">*{{ errors.email[0] }}</small>

                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputFile"  class="col-sm-2 control-label">File input</label>
                        <input type="file" @change="updateImage"   class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                       
                     </div>
                     
                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success" @click.prevent="updateProfile">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
            <!-- user settings  ends-->
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                user:{
                  name:'',
                  type:'',
                  photo:'',
                  email:'',
                  password:'',
                  new_password:'',
                  current_password:'',
              },
                errors:{},
                message:''
            }
        },
        mounted(){
            axios.get('api/profile')
            .then((response) =>{
                this.user = response.data
                return this.user
            })

       
            
            
        },
        methods:{
          getProfilePicture(){
            let profileImage = (this.user.photo.length > 200) ? this.user.photo :  'image/profile/'+this.user.photo;
            return profileImage;
          },
          updateImage(event){
            console.log('Image Uploaded');
            // using image intervention link: http://image.intervention.io/
            let file = event.target.files[0];
            console.log(file);
            if(file['size'] < 2111775){
              let reader = new FileReader();
              reader.onloadend = (file) => {
                this.user.photo = reader.result
              }
              reader.readAsDataURL(file);
            }else{
              swal({
                type:'error',
                title: 'Opps something happened!!',
                text: 'You are uploading a large file!'
              })
            }

          },
          updateProfile(){
            this.$Progress.start()
            axios.put('api/profile',this.user)
            .then(() => {

              toast({
                    type: 'success',
                    title: 'User Updated'
                })

                this.$Progress.finish()
                Reload.$emit('AfterSubmit')
                
            })
            .catch(
              (error) => this.errors = error.response.data.errors,
              this.$Progress.fail()
            )
          },
          changePassword(){
            this.$Progress.start()
            axios.post('api/profile',{
              current_password: this.user.current_password,
              new_password: this.user.new_password
            })
            .then(() => {

              toast({
                    type: 'success',
                    title: 'Password Updated'
                })

                this.user.current_password ='',
                this.user.new_password = '',

                this.$Progress.finish()
                Reload.$emit('AfterSubmit')
            })
              .catch(
                (error) => {
                  this.message = error.response.data.message,
                  this.errors = error.response.data.errors


                  toast({
                    type: 'failed',
                    title: this.message
                })

                  this.$Progress.fail()

                 });
            
          }
        }
    }
</script>


<style>

.widget-user-header{

background-size: cover;
}
.form-control-file{
  padding: 0.375rem 0.75rem;
}

</style>
