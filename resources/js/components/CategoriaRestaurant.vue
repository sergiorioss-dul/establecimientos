<template>
  <div class="container my-5">
    <h2>Restaurants</h2>
    <div class="row">
      <div
        class="col-md-4 mt-4"
        v-for="restaurant in this.restaurantes"
        v-bind:key="restaurant.id"
      >
        <div class="card">
          <div class="card-body">
            <img
              class="card-img-top"
              :src="`storage/${restaurant.imagen_principal}`"
              alt="restaurant"
            />
            <h3 class="card-title-text-primary font-weight-bold">
              {{ restaurant.nombre }}
            </h3>
            <p class="card-text">{{ restaurant.direccion }}</p>
            <p class="card-text">
              <span class="font-weight-bold"> Horario: </span>
              {{ restaurant.apertura }} - {{ restaurant.cierre }}
            </p>
            <router-link
              :to="{ name: 'establecimiento', params: { id: restaurant.id } }"
            >
              <a href="" class="btn btn-primary d-block">Ver Lugar</a>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get("/api/categorias/restaurant").then((res) => {
      this.$store.commit("AGREGAR_RESTAURANTS", res.data);
    });
  },
  computed: {
    restaurantes() {
      return this.$store.state.restaurantes;
    },
  },
};
</script>