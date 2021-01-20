<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="" v-if="PreShops.length == 0">
                <div class="alert alert-light" role="alert">
                    <h4 class="alert-heading">You don't have a prefered Shop</h4>
                </div>
            </div>
            <div class="card mx-3 my-5"  v-for="PreShop in PreShops"  :key="PreShop.id">
                <img :src="`${publicPath}/images/shops.png`">
                <div class="card-body details-shop mt-5 border-bottom">
                    <h5 class="name-shop">{{PreShop.name}}
                        <small>{{getDistance(PreShop.location.coordinates)}} Km</small>
                    </h5>
                    <div class="info-shop">
                        <span>Contact info</span>
                        <span>{{PreShop.city}}</span>
                        <span>{{PreShop.email}}</span>
                    </div>
                </div>
                <div class="card-body rate-shop">
                    <i class="fas fa-heart pr-3"></i>
                    <i class="far fa-trash-alt pr-3" @click="removeLike(PreShop._id)"></i>
                </div>
            </div>
        </div> 
    </div>
       
</template>

<script>
    export default {
        data() {
            return {
                publicPath: window.location.origin,
                defaultLat : 33.9692139,
                defaultLang : -6.8922821,
                newLat : null,
                newLong : null,
                PreShops: []
            }
        },

        mounted() {
            this.PreShops = this.$store.state.preferedShops;
        },

        methods: {

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

            removeLike(id) {
                var allData = this.$store.state.preferedShops;
                var Shop = [];
                
                allData = this.$store.state.preferedShops.filter( shop => {
                    Shop = this.$store.state.preferedShops.filter( shop => {
                        return shop._id == id;
                    });
                    return shop._id != id;
                });  

                this.PreShops = []
                console.log(allData.length)
                for (var i = 0; i < allData.length ; i++) {
                        this.PreShops = allData[i];
                } 
                
                this.$store.commit('removePreShops', allData);
                this.$store.commit('addShops', Shop);
            }

        },

    }
</script>

<style scoped>

.card {
    width: 15rem;
    align-items: center;
    margin-top: 3em;  
    border-radius: 15px;
}

.card img {
    position: absolute;
    height: 100px;
    width: 100px;
    top: -3em;
    border-radius: 100%;
    border: 3px solid #1212;
}

.details-shop {
    display: grid;
    width: -webkit-fill-available;
    padding: 1em 1em 0.5;
}

.details-shop small{
    opacity: 60%;
    font-weight: 500;
    font-size: 12px;
}

.info-shop {
    display: grid;
    justify-content: center;
}

.info-shop span {
    display: flex;
    justify-content: center;
    opacity: 80%;
    color: #121;
}

.rate-shop {
    width: -webkit-fill-available;
    padding: 0.5em 1em 0.5em;
    justify-content: space-between;
    display: flex;
}

.rate-shop .fa-heart {
    cursor: pointer;
    color: tomato;
    font-size: 22px;
}

.rate-shop .fa-trash-alt {
    cursor: pointer;
    opacity: 80%;
    font-size: 22px;
}

</style>
