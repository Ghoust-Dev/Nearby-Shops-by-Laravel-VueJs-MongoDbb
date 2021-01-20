import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    isLogined: false,
    loaded: true,
    Shops: [],
    preferedShops: [],
    disLikeShops: [],
  },
  mutations: {
    isLoaded (state) {
        state.loaded = false
    },

    isLogined (state, status) {
        state.isLogined = status;
    },

    showShops (state, Shops) {
        state.Shops = Shops;
    },

    updateShops (state, Shops) {
        state.Shops = Shops;
    },

    addShops (state, addShops) {        
        state.Shops.push(...addShops);
    },

    updatePreShops (state, newPreShops) {        
        state.preferedShops.push(...newPreShops);
    },

    removePreShops (state, PreShops) {        
        state.preferedShops = PreShops;
    },

    disLikeShops (state, disLikeShop) {
        state.disLikeShops.push(...disLikeShop);
    }

  }
})

export default store