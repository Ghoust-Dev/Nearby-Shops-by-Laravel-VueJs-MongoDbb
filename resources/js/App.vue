<template>
    <div class="container" >
        <div class="" v-if="this.$store.state.isLogined">
            <div class="select-option" >
                <router-link to="/" class="all-shops mr-2">
                    All Shops
                </router-link>
                <router-link to="/prefered-shops" class="prefered-shops">
                    Prefered Shops
                </router-link>
            </div>
            <router-view></router-view>
        </div>         
        <div style="display:flex; justify-content:center" v-else>
            <div class="alert alert-light" role="alert">
                <h4 class="alert-heading">You should Sign-in to see the Nearby Shops</h4>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {     
            
        getUser:{
            axios.get('/api/users')
            .then(response => {
                this.$store.commit('isLogined',true);
            }).catch(err => {
                this.$store.commit('isLogined',false);
            })
        }
    },
}
</script>

<style scoped>

.select-option {
    display: flex;
    justify-content: center;
    padding: 1em;
}

.select-option .all-shops,
.select-option .prefered-shops{
    border-radius: 30px;
    background-color: transparent;
    border-color: tomato;
    border: 1px solid;
    color: tomato;
    padding: 3px 0.7em;
    cursor: pointer;
    text-decoration-line: none;
}

.active{
    background-color: tomato !important;
    color: #fff !important;   
}

.select-option .all-shops:hover,
.select-option .prefered-shops:hover{
    background-color: tomato !important;
    color: #fff !important;
}

</style>