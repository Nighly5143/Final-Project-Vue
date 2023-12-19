<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const cars = ref([]);
const router = useRouter();

onMounted(async () => {
  await fetchCars();
});

const fetchCars = async () => {
  try {
    const response = await fetch("http://localhost:8000/api/cars");
    const data = await response.json();
    console.log(data); // Log the response
    cars.value = data;
  } catch (error) {
    console.error("Error fetching cars:", error);
  }
};

const deleteCar = async (carId) => {
  try {
    const response = await fetch(`http://localhost:8000/api/cars/${carId}`, {
      method: "DELETE",
    });

    if (response.ok) {
      // Remove the deleted car from the list
      cars.value = cars.value.filter((car) => car.id !== carId);
      alert("Car deleted successfully");
      console.log("Car deleted successfully");
    } else {
      console.error("Error deleting car:", response.statusText);
    }
  } catch (error) {
    console.error("Error deleting car:", error);
  }
};
</script>

<template>
  <div>
    <h1>&nbsp;</h1>
    <div class="d-grip gap-2 d-md-flex justify-content-md-end mb-3">
      <router-link
        to="/car/carcreate"
        class="btn btn-primary mo-md-2"
        id="addButton"
        type="button"
      >
        Add New Car
      </router-link>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Brand</th>
          <th>Model</th>
          <th>Year</th>
          <th>Rental Rate</th>
          <th>&nbsp;</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="car in cars" :key="car.id">
          <td>{{ car.brand }}</td>
          <td>{{ car.model }}</td>
          <td>{{ car.year }}</td>
          <td>{{ car.rental_rate }}</td>
          <td>
            <!-- Display additional details or image if needed -->
          </td>
          <td>
            <button @click="deleteCar(car.id)" class="btn btn-danger">
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
body {
  font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.table {
  border-radius: 20px;
  width: 1000px;
  justify-content: center;
  margin: auto;
  flex-direction: column;
}

#addButton {
  background-color: blue;
}

</style>
