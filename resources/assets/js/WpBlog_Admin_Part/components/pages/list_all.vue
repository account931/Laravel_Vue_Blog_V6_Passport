<template>
	<div class="services">
		<h1> {{title}}</h1>
		<p></p>
        
		<!--------- Unauthorized/unlogged Section ------> 
        <div v-if="this.$store.state.passport_api_tokenY == null" class="col-sm-12 col-xs-12 alert alert-info"> <!--auth check if Passport Token is set, i.e user is logged -->
            
            <!-- Display subcomponent/you_are_not_logged.vue -->
            <you-are-not-logged-page></you-are-not-logged-page>         
        </div>
        
		
		
		<!--------- Authorized/Logged Section ----------> 
        <div v-else-if="this.$store.state.passport_api_tokenY != null">
        
		
		
		     <!-- If there is no blog records so far -----> <!-- amendment 30.03.2022 -->
			<div v-if="booksGet.length == 0"> 
                <hr>			
			    <p class="text-danger">No records found so far</p>
			</div>
			<!-- End If there is no blog records so far -->
			
			
			
            <!-- V loop over ajax success data -->
            <div v-for="(postAdmin, i) in booksGet" :key=i class="col-sm-12 col-xs-12 oneAdminPost" :id="postAdmin.wpBlog_id"> 
                <p> {{postAdmin.wpBlog_title}} </p>
                <p> {{truncateText(postAdmin.wpBlog_text)}} </p>
            
                <!-- Image with LightBox -->
	            <a v-if="postAdmin.get_images.length" :href="`images/wpressImages/${postAdmin.get_images[0].wpImStock_name}`"   title="image" :data-lightbox="`roadtrip${postAdmin.wpBlog_id}`" > <!-- roadtrip + currentID, to create a unique data-lightbox name, so in modal LightBox will show images related to this article only, not all -->
                    <img v-if="postAdmin.get_images.length" class="card-img-top my-adm-img" :src="`images/wpressImages/${postAdmin.get_images[0].wpImStock_name}`"  @error="imageUrlAlt" />       <!-- @error - is a method to run if image url is invalid or broken or image physically not available in folder -->
	            </a>
                <!-- End Image with LightBox -->
		
                <!-- If image does not exist (not connected via hasOne relation). ELSE -->
                <img v-else class="card-img-top my-img" :src="`images/no-image-found.png`" />
            
                <!-- Edit/Delet Buttons --> 
                <hr>            
                <p>  
                    <button style="font-size:19px" class="btn btn-success" @click="goToEditDetail(postAdmin.wpBlog_id)">Edit   <i class="fa fa-pencil"></i></button>
                    <button style="font-size:19px" class="btn btn-danger"  @click="deletePost(postAdmin.wpBlog_id)"> Delete <i class="fa fa-trash-o"></i></button>
                </p>
        </div>
        <!-- End V loop over ajax success data -->
		
		</div>
        <!------------ END Authorized/Logged Section -----------------> 
        
	</div>
</template>

<script>
    import { mapState } from 'vuex';
	//using other sub-component 
    import youAreNotLogged  from '../subcomponents/you_are_not_logged.vue'; 
	export default{
		name:'blog',
		//using other sub-component 
	    components: {
            'you-are-not-logged-page' : youAreNotLogged,
        },
		data (){
			return{
				title:'List all blog entries',
                ajaxList: [], //[ {wpBlog_title:'bl', wpBlog_text:'bl-text', wpBlog_author:1, get_images:[{wpImStock_id:56, wpImStock_name:"product2.png"}]}, {wpBlog_title:'bl2', wpBlog_text:'bl-text2', wpBlog_author:1, get_images:[{wpImStock_id:56, wpImStock_name:"product2.png"}]} ],
			}
		},
        
        
        computed: {
            //...mapState(['ajaxList']),
            booksGet() { //make reactive ajax response 
                return this.ajaxList;
            }
           
        },
        
        
        beforeMount() { 
            let token = document.head.querySelector('meta[name="csrf-token"]'); //gets meta tag with csrf //NOT USED in Passport????
            //alert(token.content);
	        this.tokenXX = token.content; //gets csrf token and sets it to data.tokenXX //NOT USED in Passport???? This is csrf token used to verify form submission. For READ operation (get all posts) it is not required
			
			//Passport token check
            if(this.$store.state.passport_api_tokenY == null){
                swal("List_all says: Access denied", "You are not logged", "error");
                return false;
            }
            this.runAjaxToGetPosts();
        }, 
        
        
        methods: {
		    /*
            |--------------------------------------------------------------------------
            | If image url is invalid or broken or image physically not available in folder, then use 'images/image-corrupted.jpg"
            |--------------------------------------------------------------------------
            |
            |
            */
		    imageUrlAlt(event) {
                event.target.src = "images/image-corrupted.jpg"
            },
			
              
           /*
            |--------------------------------------------------------------------------
            | Get all posts (ajax)
            |--------------------------------------------------------------------------
            |
            |
            */
            runAjaxToGetPosts(/*{ commit, state  }*/) {
               
                var that = this; //Explaination => if you use this.data, it is incorrect, because when 'this' reference the vue-app, you could use this.data, but here (ajax success callback function), this does not reference to vue-app, instead 'this' reference to whatever who called this function(ajax call)
                console.log('start getting articles for admin section');
                $('.loader-x').fadeIn(800); //show loader
               
                //Add Bearer token to headers
                $.ajaxSetup({
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.state.passport_api_tokenY // this.$store.state.api_tokenY //was used in Laravel Blog v.1
                    }
                }); 
      
		        $.ajax({
		            url: 'api/post/admin_get_all_blog', 
                    type: 'GET', //
                    cache : false,
                    dataType    : 'json',
                    processData : false,
                    contentType: false,
                    //contentType:"application/json; charset=utf-8",						  
                    //contentType: 'application/x-www-form-urlencoded; charset=utf-8',
                    //contentType: 'multipart/form-data',
			        //crossDomain: true,
			        //headers: {'Content-Type': 'application/x-www-form-urlencoded', 'Authorization': 'Bearer ' + this.$store.state.passport_api_tokenY }, //this.$store.state.api_tokenY //was used in Laravel Blog v.1
                    //headers: { 'Content-Type': 'application/json',  },
			        //contentType: false,
			        //dataType: 'json', //In Laravel causes crash!!!!!// without this it returned string(that can be alerted), now it returns object
           
			        //passing the data
                    data: {  _token: this.tokenXX, }, //csrf token, though here is not required
		    
                    success: function(data) {
                        console.log("articles are successfully fetched");            
                        console.log("success" + JSON.stringify(data, null, 4));
                
                        if(data.error == true ){ //if Rest endpoint returns any predefined error
                            var text = data.data;
                            swal("Check", text, "error");
                  
                        } else if(data.error == false){ //if all is OK
                            that.ajaxList = data.data; 
                            console.log("all articles: " + data.data);
                            console.log("1st artcile: " + that.ajaxList[0].wpBlog_title);
                            var tempoArray = []; 
                    
                            //run a Vuex store method to set the quantity of found articles
                            that.$store.dispatch('setPostsQuantity', data.data.length); 
                    
                            swal("Good", "Bearer Token is OK", "success");
                            swal("Good",  "All articles are loaded"/*data.data*/, "success");
                        }
                        $('.loader-x').fadeOut(800); //hide loader
                    },  //end success
            
			        error: function (errorZ) {
                        alert("Crashed"); 
			            alert("error" +  JSON.stringify(errorZ, null, 4));
                        console.log(errorZ.responseText);
                        console.log(errorZ);

                        if(errorZ.responseJSON != null){
						    /*
                            if(errorZ.responseJSON.error == true || errorZ.responseJSON.error == "Unauthenticated."){ //if Rest endpoint returns any predefined error
                                swal("Error: Unauthenticated", "Check Bearer Token", "error");  
                                //alert("Unauthenticated");                  
                            } */
							if (errorZ.responseJSON.error == "Error: Request failed with status code 401" ||  errorZ.responseJSON.error == "Unauthenticated."){ //if Rest endpoint returns 401 error

                                swal("Unauthenticated", "Check Bearer Token", "error");
								alert('Vuex log out - pre'); 
								
                                //Unlog the user if dataZ.error == "Unauthenticated." || 401, otherwise if user has wrong password token saved in Locals storage, he will always recieve error and neber log out                  
                                that.$store.dispatch('LogUserOut'); //reset state vars (state.passport_api_tokenY + state.loggedUser) via mutation
                            } else {  

                               swal("Error", "Something else crashed", "error"); 
                            }
                        }
                        //swal("Error", "Something crashedd", "error"); //Commented or it will overleap and prevent to appear  swal("Error: Unauthenticated  
                        $('.loader-x').fadeOut(800); //hide loader
                
			        }	





                   
					
                });                             
                //END AJAXed  part
            
            },
            
            
            truncateText(text) {
                if (text.length > 64) {
                    return `${text.substr(0, 64)}...`;
                }
                return text;
            },
            
            
           /*
            |--------------------------------------------------------------------------
            | Ajax to Delete one item
            |--------------------------------------------------------------------------
            |
            |
            */
            deletePost(item){
            
                if(!confirm('Sure to delete Post ' + item + '?')){
                    return false;
                }
                $('.loader-x').fadeIn(800); //show loader
                var that = this; //to fix context issue
                this.selectedItem = item;
                alert('Delete ' + this.selectedItem + " Implement REST API delete function");
                
                //Add Bearer token to headers
                $.ajaxSetup({
                    headers: {
                        'Authorization': 'Bearer ' + this.$store.state.passport_api_tokenY //PASSPORT api_tokenY
                    }
                }); 
      
		        $.ajax({
                          
		            url: 'api/post/admin_delete_item/' + this.selectedItem, 
                    type: 'DELETE', //
                    cache : false,
                    dataType    : 'json',
                    processData : false,
                    contentType: false,
			        //crossDomain: true,
			        //headers: {'Content-Type': 'application/x-www-form-urlencoded', 'Authorization': 'Bearer ' + this.$store.state.passport_api_tokenY},  //this.$store.state.api_tokenY
                    //headers: { 'Content-Type': 'application/json',  },
			        //contentType: false,
			        //dataType: 'json', //In Laravel causes crash!!!!!// without this it returned string(that can be alerted), now it returns object
           
			        //passing the data
                    data: {},
		    
                    success: function(data) {
                        alert("success");            
                        alert("success" + JSON.stringify(data, null, 4));
                
                        if(data.error == true ){ //if Rest endpoint returns any predefined error
                            var text = data.data;
                            swal("Check", text, "error");
                    
                            //if validation errors (NOT THE CASE FOR DELETE) (i.e if REST Contoller returns json ['error': true, 'data': 'Good, but validation crashes', 'validateErrors': title['Validation err text'],  body['Validation err text']])
                            if(data.validateErrors){
                                var tempoArray = []; //temporary array
                                for (var key in data.validateErrors) { //Object iterate
                                    var t = data.validateErrors[key][0]; //gets validation err message, e.g validateErrors.title[0]
                                    tempoArray.push(t);
                                }
                            }
                        //if REST endpoint returns OK  
                        } else if(data.error == false){
                            swal("Good", "Bearer Token is OK", "success");
                            swal({html:true, title: "Deletion was OK", text: data.data, type: "success"});
                            that.runAjaxToGetPosts(); //renew the list
                        }
						$('.loader-x').fadeOut(800); //hide loader
                    },  //end success
            
			        error: function (errorZ) {
                        alert("Crashed"); 
			            alert("error" +  JSON.stringify(errorZ, null, 4));
                        console.log(errorZ.responseText);
                        console.log(errorZ);
                
                        if(errorZ.responseJSON != null){
                            if(errorZ.responseJSON.error == "Error: Request failed with status code 401" ||  errorZ.responseJSON.error == "Unauthenticated."){ //if Rest endpoint returns any predefined error
                                swal("Error: Unauthenticated", "Check Bearer Token", "error"); 
                                alert('Vuex log out - pre'); 
								
                                //Unlog the user if dataZ.error == "Unauthenticated." || 401, otherwise if user has wrong password token saved in Locals storage, he will always recieve error and neber log out                  
                                that.$store.dispatch('LogUserOut'); //reset state vars (state.passport_api_tokenY + state.loggedUser) via mutation							   
                            } else {  

                               swal("Error", "Something else crashed", "error"); 
                            }
                        }
                        //swal("Error", "Something crashed", "error"); //Commented or it will overleap and prevent to appear  swal("Error: Unauthenticated
                        $('.loader-x').fadeOut(800); //hide loader						

			        }	  
                });                             
                //END AJAXed  part 
                
            },
            


            
            
           
           /*
            |--------------------------------------------------------------------------
            | Router action to view one Blog/Item
            |--------------------------------------------------------------------------
            |
            |
            */
            goToEditDetail(prodId) {
                let proId = prodId;
                this.$router.push({name:'edit-one-item',params:{PidMyID:proId}}) //creates route like "/wpBlogVueFrameWork#/details/3"
            }, 
        },
        
        
        mutations: {},
        
	}
</script>

<style scoped>
	
</style>