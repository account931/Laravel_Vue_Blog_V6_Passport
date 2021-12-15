<!-- Vue Menu for One Menu <li> Item (switches text "login"/"logged")(component used in Menu in /views/layouts/app.php) -->
<!-- Changing text values ("login"/"logged") works but on reload only, not reactive -->

<template>
   
    <!-- <li v-if="this.$store.state.passport_api_tokenY == null"> <a href="#">  LoginXz </a> </li> -->
	<span>  {{ ifPassportTokenSet == null ? 'LoginX' :  'LoggedX-Dashboard' }}   </span>  <!-- Vuex Getter: {{this.$store.getters.isLoggedIn}} St: {{storeX}} -->    <!--  {{ this.$store.getters.getCart }} -->
    
</template>

<script>
    import { mapState } from 'vuex';
    export default {
	    name: 'one-item-menu',
	    data () {
            return {
			    storeX: this.$store.getters.isLoggedIn,
                //dialogImageUrl: '',
                //dialogVisible: false, //flag
                //imageList: [],        //stores uploaded images
           }
        },
		
	
        mounted() {
            //console.log('Component mounted.');
		    //$('.remove').contents().unwrap();
        },
		
		computed: { 
            ifPassportTokenSet() {
                return this.$store.state.passport_api_tokenY;
			},
		},
    }
</script>


