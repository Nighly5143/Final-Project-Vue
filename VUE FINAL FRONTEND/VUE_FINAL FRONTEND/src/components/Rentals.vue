<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const rentals = ref([]);
const router = useRouter();

onMounted(async () => {
  await fetchRentals();
});

const fetchRentals = async () => {
  try {
    const response = await fetch("http://localhost:8000/api/rentals");
    const data = await response.json();
    
    // Assuming the rentals array is nested under a key named 'rentals'
    const rentalsArray = data.rentals || data;

    console.log(rentalsArray); // Log the response
    rentals.value = rentalsArray;
  } catch (error) {
    console.error("Error fetching rentals:", error);
  }
};

const deleteRental = async (rentalId) => {
  try {
    const response = await fetch(`http://localhost:8000/api/rentals/${rentalId}`, {
      method: "DELETE",
    });

    if (response.ok) {
      // Remove the deleted rental from the list
      rentals.value = rentals.value.filter((rental) => rental.id !== rentalId);
      alert("Rental deleted successfully");
      console.log("Rental deleted successfully");
    } else {
      console.error("Error deleting rental:", response.statusText);
    }
  } catch (error) {
    console.error("Error deleting rental:", error);
  }
};
</script>

<template>
  <div>
    <h1>&nbsp;</h1>
    <div class="d-grip gap-2 d-md-flex justify-content-md-end mb-3">
      <router-link
        to="/rental/rentalcreate"
        class="btn btn-primary mo-md-2"
        id="addButton"
        type="button"
      >
        Add New Rental
      </router-link>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Car</th>
          <th>Rental Date</th>
          <th>Return Date</th>
          <th>Total Cost</th>
          <th>&nbsp;</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="rental in rentals" :key="rental.id">
          <td>{{ rental.id }}</td>
          <td>{{ rental.customer.first_name }} {{ rental.customer.last_name }}</td>
          <td>{{ rental.car.brand }} {{ rental.car.model }}</td>
          <td>{{ rental.rental_date }}</td>
          <td>{{ rental.return_date }}</td>
          <td>{{ rental.total_cost }}</td>
          <td>
            <!-- Display additional details or image if needed -->
          </td>
          <td>
            <button @click="deleteRental(rental.id)" class="btn btn-danger">
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
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
