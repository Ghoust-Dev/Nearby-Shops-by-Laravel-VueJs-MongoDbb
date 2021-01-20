<template>
    <div class="container">
        <div class="mx-5 mt-2 mb-4" style="display:flex; align-items:center;">
            <label class="mr-2">Sort by Distance</label>
            <select name="" id="" class="form-control col-2" @change="SortShops($event)">
                <option value="asc">Ascending</option>
                <option value="desc">Descending </option>
            </select>
        </div>         
        <div class="row justify-content-center">
            <Shop :Shops="shops" @isLiked="isLiked"  @disLiked="disLiked"/>
        </div>
        <div v-if="shops.length" v-observe-visibility="visibilityChanged"></div>
        <infinite-loading v-if="this.$store.state.loaded"></infinite-loading> 
    </div>
</template>

<script>
import Shop from "../components/Shop";

    export default {
        name: "Home",
        components:{
            Shop,
        },

        data() {
            return {
                publicPath: window.location.origin,
                shops: [],
                preferedShops: [],
                disLikeShop: [],
                allData: this.$store.state.Shops,
                perpage : 30,
                firstEl: 0,
                sortShops: 'asc',
                
                defaultLat : 33.9692139,
                defaultLang : -6.8922821,
                newLat : null,
                newLong : null,
            }
        },

        mounted() {
            this.fetch() 
            
        },

        methods:{
            async fetch() {
                if(this.$store.state.loaded){
                    await axios.get(`${this.publicPath}/api/showShops`).then(res => {
                        Object.values(res.data).forEach(shops =>{
                            this.$store.commit('showShops',shops);
                            this.allData = shops;
                        });
                        this.$store.commit('isLoaded')
                        this.displayData();
                    });
                }else {
                    this.allData = this.$store.state.Shops;
                    this.displayData();
                }
                setInterval(this.retreiveShop,60000);
            },

            displayData() { 
                
                if(this.sortShops === 'asc'){
                    this.allData.sort((a, b) => 
                        (this.getDistance(a.location.coordinates) > this.getDistance(b.location.coordinates)) ? 1 : -1);
                }else {
                    this.allData.sort((a, b) => 
                        (this.getDistance(a.location.coordinates) < this.getDistance(b.location.coordinates)) ? 1 : -1);
                }
                
                for (var i = this.firstEl; i < this.perpage; i++) {
                    if(!this.allData[i].Disliked) {
                        this.shops.push(this.allData[i]);
                    }                        
                }
            },

            visibilityChanged (isVisible) {
                if(!isVisible){
                    return
                }
                this.firstEl = this.perpage;
                this.perpage += this.perpage;
                this.displayData();
            },

            SortShops(e){
                this.sortShops = e.target.value;
                this.shops = [];
                this.firstEl = 0;
                this.perpage = 30;
                this.displayData();
            },

            isLiked(id) {
                this.allData = this.allData.filter( shop => {
                    this.preferedShops = this.allData.filter( shop => {                    
                        return shop._id == id;
                    });
                    return shop._id != id;
                });   
                this.shops = [];
                this.displayData();
                this.$store.commit('updatePreShops', this.preferedShops);
                this.$store.commit('updateShops', this.allData);
                
            },

            disLiked(id) {
                this.allData = this.allData.filter( shop => {
                    return shop._id != id;
                });   

                this.$store.commit('updateShops', this.allData);  

                axios.get(`${this.publicPath}/api/disLikedShop/${id}`);

                this.shops = [];
                this.displayData();
            },

            retreiveShop() {                
                axios.get(`${this.publicPath}/api/showShops`).then(res => {
                        Object.values(res.data).forEach(shops =>{                            
                            Object.values(shops).forEach(shop =>{
                                if(shop.timeDisliked <= Date.now())
                                {
                                    console.log(shop.timeDisliked)
                                    axios.get(`${this.publicPath}/api/removeDisLikedShop/${shop._id}`);
                                }
                            });  
                        });
                });
            },

            getDistance(distance) {

                this.newLong = distance[0]; 
                this.newLat = distance[1];   

                var R = 6371; // Radius of the earth in km
                var dLat = this.deg2rad(this.newLat-this.defaultLat);  // deg2rad below
                var dLon = this.deg2rad(this.newLong-this.defaultLang); 
                var a = 
                    Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(this.deg2rad(this.defaultLat)) * Math.cos(this.deg2rad(this.newLat)) * 
                    Math.sin(dLon/2) * Math.sin(dLon/2)
                    ; 
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                var d = R * c; // Distance in km
                
                return Math.trunc(d);
            },

            deg2rad(deg) {
                return deg * (Math.PI/180)
            },
        }
        
    }
</script>


 