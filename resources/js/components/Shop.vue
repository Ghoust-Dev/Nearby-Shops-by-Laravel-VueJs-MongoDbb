<template>
    <div class="" style="display: contents;">
        <div class="card mx-3 my-5"  v-for="Shop in Shops"  :key="Shop.id">
            <img :src="`${publicPath}/images/shops.png`">
            <div class="card-body details-shop mt-5 border-bottom">
                <h5 class="name-shop">{{Shop.name}}
                    <small>{{getDistance(Shop.location.coordinates)}} Km</small>
                </h5>
                <div class="info-shop">
                    <span>Contact info</span>
                    <span>{{Shop.city}}</span>
                    <span>{{Shop.email}}</span>
                </div>
            </div>
            <div class="card-body rate-shop">
                <i class="far fa-thumbs-up pr-3" @click="$emit('isLiked',Shop._id)"></i>
                <i class="far fa-thumbs-down" @click="$emit('disLiked',Shop._id)"></i>
            </div>
        </div>
    </div>    
</template>

<script>
    export default {
        props:[
            'Shops',
            'Distance'
        ],

        data() {
            return {
                publicPath: window.location.origin,
                defaultLat : 33.9692139,
                defaultLang : -6.8922821,
                newLat : null,
                newLong : null,
            }
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
}

.rate-shop .fa-thumbs-up {
    cursor: pointer;
    color: skyblue;
    font-size: 22px;
}

.rate-shop .fa-thumbs-down {
    cursor: pointer;
    color: red;
    font-size: 22px;
}

</style>
