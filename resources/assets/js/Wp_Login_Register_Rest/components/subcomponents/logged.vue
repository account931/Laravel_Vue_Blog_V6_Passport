<!-- Uses Vuex store: this.$store.state.loggedUser + this.$store.state.api_tokenY -->

<template>

    <div class="col-sm-12 col-xs-12 alert alert-info borderX">
        <center>
           <p> click to Log Out <button class="btn btn-success" @click="logMeOut"> Log out </button> </p>
		   <p> Your name is..... {{this.$store.state.loggedUser.name}} </p>
           <p> Token is          {{this.$store.state.api_tokenY }} </p>
        </center>
    </div>

</template>

<script>

export default {
    name: 'all-posts',
    data() {
        return {
            //postDialogVisible: false,
        };
    },
  
    //computed property is used to declaratively describe a value that depends on other values. When you data-bind to a computed property inside the template, Vue knows when to update the DOM when any of the values depended upon by the computed property has changed.
    computed: { 
    },
    beforeMount() {
    },
    methods: {
        logMeOut(){
            alert("do log out");
        },
    },
}
</script>