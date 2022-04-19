<!-- View 1 blog via router -->
<template>
	<div class="contact">
		
		
		
		<!--------- Unauthorized/unlogged Section ------> 
        <div v-if="this.$store.state.passport_api_tokenY == null" class="col-sm-12 col-xs-12 alert alert-info"> <!--auth check if Passport Token is set, i.e user is logged -->
            <!-- Display subcomponent/you_are_not_logged.vue -->
            <you-are-not-logged-page></you-are-not-logged-page>         
        </div>
        
        
        
        <!--------- Authorized/Logged Section ----------> 
        <div v-else-if="this.$store.state.passport_api_tokenY != null">
				
		    <p>Details</p>
			
			
			<!-- If no records -->
            <div v-if="this.$store.state.posts.length == 0" class="col-sm-12 col-xs-12"> 
                <hr>			
			    <p class="text-danger"> No data fetched for yout Post {{ this.$route.params.Pidd }} , visit first <br> <router-link class="nav-link" to="/New_2021"> <button class="btn btn-success"> Vue Crud panel </button> </router-link> </p>
		    </div>
				
			

            <!-------- If  records are available || records are not null ---------------->
		    <div v-else class="col-sm-12 col-xs-12">
				
				
			    <!------- If record ID does not exist in this.$store.state.posts (user intentionally inputs wrong ID)----->
                <div v-if="this.$store.state.posts[this.currentDetailID] == undefined" class="col-sm-12 col-xs-12"> 
                    <hr>			
			        <p class="text-danger"> Article ID {{ this.$route.params.Pidd }} does not exist , visit first <br> <router-link class="nav-link" to="/New_2021"> <button class="btn btn-success"> Vue Crud panel </button> </router-link> </p>
		        </div>
				<!-- End If record ID does not exist in this.$store.state.posts (user intentionally inputs wrong ID)  -->
			
		
		
		        <!------------ If record ID exist in this.$store.state.posts, then show it ------------->
                <div v-else class="col-sm-12 col-xs-12">
				
				
			
		
		            <p>Details</p>
		
		
		
		            <!------ Mine, Just to check if Store is working and connected --------->
		            <!-- Gets Vuex store from store/index.js -->
		            <!-- Foreach -->	
		            <span v-for="posts in checkStore" :key="posts.wpBlog_id"> 
                      {{  posts.wpBlog_id }} {{ posts.wpBlog_title }}  
                    </span>
		            <!------ Mine, Just to check if Store is working and connected --------->
	    
		
		
		
		
		            <!-- Show one product, based on URL ID. Gets values from Vuex store in "/store/index.js" -->
		            <!-- {{  this.$store.state.posts[this.currentDetailID].wpBlog_id }} == same ==> {{  checkStore[this.currentDetailID].productId }} == same as(if used {...mapState(['products']),}) ==> products[this.currentDetailID].productId-->
		            <div>
		                <hr>
            
                        <!-- Nav Link go back -->
                        <p class="z-overlay-fix-2"> 
                            <router-link class="nav-link" to="/New_2021">
                                <button class="btn">Back to Blog_2021 <i class="fa fa-tag" style="font-size:14px"></i></button>
                            </router-link>
                        </p>
                        <!-- End Nav Link go back -->
		    
                        <p> One product </p>
		                <p> {{ this.$store.state.posts[this.currentDetailID].wpBlog_id }} {{ this.$store.state.posts[this.currentDetailID].wpBlog_title }}</p>
            
                        <!-- Show the first image -->
			            <!-- Simple image -->
                        <p> 
			                <img :src="`images/wpressImages/${this.$store.state.posts[this.currentDetailID].get_images[0].wpImStock_name}`"  v-if="this.$store.state.posts[this.currentDetailID].get_images.length" class="card-img-top my-img"> 
		    
			                <!-- If image does not exist (no image connected via hasOne relation).  ELSE -->
                            <img v-else class="card-img-top my-img-small" :src="`images/no-image-found.png`" />
			            <p>

			
                        <p>           {{ this.$store.state.posts[this.currentDetailID].wpBlog_text }} </p>
                        <p> Author:   {{ this.$store.state.posts[this.currentDetailID].author_name.name }} </p>
                        <p> Email:    {{ this.$store.state.posts[this.currentDetailID].author_name.email }} </p>
                        <p> Category: {{ this.$store.state.posts[this.currentDetailID].category_names.wpCategory_name }} </p>

           
                        <!-- Show all article images via FOR LOOP except for first. HasMany Relation -->
                        <div class="col-md-12" v-for="(img, i) in this.$store.state.posts[this.currentDetailID].get_images" :key=i>
                            <div v-if="i > 0">
                                 <img :src="`images/wpressImages/${img.wpImStock_name}`" class="img-thumbnail" alt="">
                            </div>
                        </div>
          
          
                     
                    </div>
		            <!-- Show one product, based on URL ID -->
	             
                </div><!-- End If record ID exist in this.$store.state.posts, then show it	-->
				
	        </div><!-- End If  records are available || records are not null-->	
			
		    <br><br>
	    </div> 
        <!--------- Authorized/Logged Section ----------> 
	
    </div>
</template>


<script>
import { mapState } from 'vuex';
//using other sub-component 
import youAreNotLogged  from '../subcomponents/you_are_not_logged.vue';
export default {
    name: 'details-info',
	//using other sub-component 
	components: {
        'you-are-not-logged-page' : youAreNotLogged,
    },
    data() {
        return {
            //postDialogVisible: false,
	        currentDetailID: 1, 
        };
    },
  
    //computed property is used to declaratively describe a value that depends on other values. When you data-bind to a computed property inside the template, Vue knows when to update the DOM when any of the values depended upon by the computed property has changed.
    computed: {
	    ...mapState(['posts']), //is needed for Vuex store, after it u may address Vuex Store value as {products} instead of {this.$store.state.products}

	 
	    //mine test
	    checkStore() {
            console.log(this.$store.state.posts); //Gets values from Vuex store in "/store/index.js" 
		    return this.$store.state.posts;
        },
    },
  
    //before mount
    beforeMount() {
	
	    //Passport token check
        if(this.$store.state.passport_api_tokenY == null){
            swal("View one page says: Access denied", "You are not logged", "error");
            return false;
        } 
			
        console.log(this.$store.state.posts);
	    //getting route ID => e.g "wpBlogVueFrameWork#/details/2", gets 2. {Pid} is set in 'pages/home' in => this.$router.push({name:'details',params:{Pid:proId}})
	    var ID = this.$route.params.Pidd; //gets 2
	    ID = ID - 1; //to comply with Vuex Store array, that starts with 0
	    this.currentDetailID = ID; //set to this.state
		
		/*
		//MegaFIX variant (tested in Laravel_Gii_Crud_2022)-------------
		var ID = this.$route.params.Pidd; //gets 2, id of blog
	    //ID = ID - 1; //to comply with Vuex Store array, that starts with 0
			
	    //MegaFIX
	    //find the array position of object with "wpBlog_id" === ID in this.$store.state.posts
		let position = this.$store.state.posts.findIndex(x => x.wpBlog_id === ID);
	    //alert(position);
	    this.currentDetailID = position; //set to this.state
	    //this.currentDetailID = ID; //set to this.state
		//End MegaFIX variant (tested in Laravel_Gii_Crud_2022)----------
		*/	
			
			
    },
}
</script>

<style scoped>
.contact form{
	max-width: 40em;
	margin: 2em auto;
}
.contact form .form-control{
	margin-bottom: 1em;
}
.contact form textarea{
	min-height: 20em;
}	
</style>