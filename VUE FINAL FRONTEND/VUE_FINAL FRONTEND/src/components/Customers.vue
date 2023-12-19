<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const customers = ref([]);
const router = useRouter();

onMounted(async () => {
  await fetchCustomers();
});

const fetchCustomers = async () => {
  try {
    const response = await fetch("http://localhost:8000/api/customers");
    const data = await response.json();

    // Assuming the customers array is nested under a key named 'customers'
    const customersArray = data.customers || data;

    console.log(customersArray); // Log the response
    customers.value = customersArray;
  } catch (error) {
    console.error("Error fetching customers:", error);
  }
};

const deleteCustomer = async (customerId) => {
  try {
    const response = await fetch(`http://localhost:8000/api/customers/${customerId}`, {
      method: "DELETE",
    });

    if (response.ok) {
      // Remove the deleted customer from the list
      customers.value = customers.value.filter((customer) => customer.id !== customerId);
      alert("Customer deleted successfully");
      console.log("Customer deleted successfully");
    } else {
      console.error("Error deleting customer:", response.statusText);
    }
  } catch (error) {
    console.error("Error deleting customer:", error);
  }
};
</script>

<template>
  <div>
    <h1>&nbsp;</h1>
    <div class="d-grip gap-2 d-md-flex justify-content-md-end mb-3">
      <router-link
        to="/customer/customercreate"
        class="btn btn-primary mo-md-2"
        id="addButton"
        type="button"
      >
        Add New Customer
      </router-link>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Last Name</th>
          <th>First Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>&nbsp;</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="customer in customers" :key="customer.id">
          <td>{{ customer.last_name }}</td>
          <td>{{ customer.first_name }}</td>
          <td>{{ customer.email }}</td>
          <td>{{ customer.phone }}</td>
          <td>
            <!-- Display additional details or image if needed -->
          </td>
          <td>
            <button @click="deleteCustomer(customer.id)" class="btn btn-danger">
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
