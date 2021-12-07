<!-- Vue Menu for One Item (menu switch for login/logged)(component used in Menu in /views/layouts/app.php) -->

<template>
   
    <!-- <li v-if="this.$store.state.passport_api_tokenY == null"> <a href="#">  LoginX </a> </li>-->
	<span>  {{ ifPassportTokenSet == null ? 'LogginX' :  'LoggedX-Dashboard' }} </span>
    
</template>

<script>
    export default {
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