
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11 col-md-offset-1">
            <div class="panel panel-default">
			
			
			    <!-- Flash message if Success -->
				@if(session()->has('flashMessageX'))
                    <div class="alert alert-success">
                        {!! session()->get('flashMessageX') !!} <!--Displays content without html escaping -->
                    </div>
                @endif
				<!-- Flash message -->
				

                <!-- Flash message if Failed -->
				@if(session()->has('flashMessageFailX'))
                    <div class="alert alert-danger">
                        {!! session()->get('flashMessageFailX') !!} <!--Displays content without html escaping -->
                    </div>
                @endif
				<!-- Flash message if Failed -->				
				

                <!-- Display form validation errors var 2 -->
				@if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                <!-- End Display form validation errors var 2 -->				
					
						
                <div class="panel-heading text-warning borderX" style="border:1px solid black;">
				    <p>
					    <img class="vue-logo" src="{{URL::to("/")}}/images/vue.png"  alt="a"/>
				        <button style="font-size:24px">Wpress Vue Passport <i class="fa fa-book"></i></button>
					</p>
				    WpBlog with Images on Vue.js framework + Vuex Store <span class="small text-danger">(It is a Vue.js version of Wpress Images (blog article with one or more images). 
					Images are LightBox-ed. This WpRess Vue.js Blog uses 3-table DB (same as Wpress Image Blog). Pagination is set by $_GET['page'], i.e if there is NO $_GET['page'] in URL, it displays first n articles)</span> 
				</div>
                
                <div class="alert alert-danger">
                    <p>100% works only with Bearer token, when u send Bearer token ({User} table field {api_token}) in ajax as HEADER  => headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + state.api_tokenY } (in Vuex store) or this.$store.state.api_tokenY (in other components) ,</p>
                    <p>FALSE=>Middleware seem to work, but have to pass api_token manually, cant get the user</p>
                </div>
                
                <div class="panel-body">
		        </div>
		    </div>
				 
				 
				 
		    <?php echo "My token is " .$myDBToken;  ?>
					
			<!----------- Vue.js Components + VUEX Store + VUE ROUTER ------------>	 
			<div class="col-sm-12 col-xs-12" >

			    <!-- Show blogs quantity component -->
			    <div id="quant" class="col-sm-12 col-xs-12">
					<h3><b>Blog articles on Vue<b></h3>
					<show-quantity-of-posts/> <!-- Vue component -->
                </div>
                    
                    
			    <!-- Vue route menu -->
			    <div  id="vue-menu" class="col-sm-12 col-xs-12"> <!--  id="vue-menu" --> 
					<h3><b>Menu with Vue-Router</b></h3>                      
                    <!-- My Vue component with Menu Links -->
					<?php //<vue-router-menu-with-link-content-display v-bind:current-user='{!! Auth::user()->toJson() !!}' > ?> <!-- Passport Changes -->
                    <vue-router-menu-with-link-content-display v-bind:current-user="'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMjg1OWVjN2Q5MmZmM2JjODM1MDkxZGVkYWExNzBiMDgzNmEyZDRiNjdiMTI5NjdhOTU3MGRkMDI5ZjMzNDIzMjAzNTE2ZmMyYTNjN2RmNmMiLCJpYXQiOjE2MjgzMzA1NzQsIm5iZiI6MTYyODMzMDU3NCwiZXhwIjoxNjU5ODY2NTc0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.yV0v_WcCoaHHe0Zu0lxYgdx1dCZDHUO3gVmWJJT6A_hFX9dDRZhwzu4PEN-rC4HcMOaJz8OOO2gogrtO5B6JZfyYTuE0rAOeRYNUi8QYLcp56cx9E8nWkG11m7XivlB_fOoAg7ZUEMNMa7lskYufkAlr6XMY7lWthUS52uilp5fAOzhPLSyMWJbzN4eyW0sv9nc6YwGBS1NPS645iJyXkabFDcir6tfMzYRMqG23nhZSc7XZ-VyhA0-E-IaaNe9g5PMMlsXCtPF5dos90DNIBDQ37S0jahpdowtskzzkC_EwLM3VKj7-Qv6GZJatfBcCzFixrhi_6v89ah-WqGRDfpT47Eo9c67Z_CeDDsOrHbhiIKv4Q6JhkiQQUegQAVCPYel8JIVkdMPUM74Ri88fNywE5lByN97m6CoDkDe2pRbAOzcA1zmIZUQYQenkHpERedWkKXF9J9ymzVA1CY-EQ2BXWKdeTTdTE3DjfGsCLd6hTvgbsiOa8o8m9kC8ZECOUcW_88zbCpHd642c8Qb6jTh655EopAhFZ_pVlzq_0fQQ_ev2T6gZp-TjqtB1dlEu5vUm548JM1idnUvndzDpe3QGFE7fHTqNFHopGTQGqgWihJpILnssRNfYxT8r7z9V55vr_hgdoV-9Fk5sdiEIEh6a2R5p7STN7ms0EfJKOZM'" >         <!-- Passport Changes (double quotes is a must-have FIX)-->

                    </vue-router-menu-with-link-content-display/>
                </div>
					
					
			    <!-- Form component -->
                <div id="createPost" class="col-md-6">
                    <!--<create-post/>--> <!-- Vue component -->
                </div>
					
			    <!-- Show all posts component -->
                <div id="app2" class="col-md-6 posts-container" style="height: 45em; overflow-y: scroll">
                    <all-posts /> <!-- Vue component -->
                </div>
                </div>		
				<!----------- Vue.js Componenet + VUEX ------------>	 		
					
               
            </div>
        </div>
    </div>
</div>


<!--------- Loader (for ajax, hidden by default) ----------------->
<div class="loader-x">
    <img src="{{URL::to("/")}}/images/loader-black.gif"  alt="a"/>
</div>
<!--------- Loader (for ajax, hidden by default)  ----------------->


@endsection
