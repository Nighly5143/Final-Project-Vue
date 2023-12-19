<template>
  <div class="row">
    <div id="container" class="col-md-5">
      <form @submit.prevent="createRental">
        <div class="customer_id">
          <label>
            <i class="fa-solid fa-id-card"></i> Customer:
            <select v-model="formData.customer_id" required class="form-control" id="customerSelect">
              <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                {{ customer.first_name }} {{ customer.last_name }}
              </option>
            </select>
          </label>
        </div>
        <div class="car_id">
          <label>
            <i class="fa-solid fa-car"></i> Car:
            <select v-model="formData.car_id" required class="form-control" id="carSelect">
              <option v-for="car in cars" :key="car.id" :value="car.id">
                {{ car.brand }} {{ car.model }}
              </option>
            </select>
          </label>
        </div>
        <div class="rental_date">
          <label>
            <i class="fa-solid fa-calendar"></i> Rental Date:
            <input v-model="formData.rental_date" type="date" required class="form-control" id="rentalDateInput" />
          </label>
        </div>
        <div class="return_date">
          <label>
            <i class="fa-solid fa-calendar"></i> Return Date:
            <input v-model="formData.return_date" type="date" required class="form-control" id="returnDateInput" />
          </label>
        </div>
        <!-- Add total_cost field -->
        <div class="total_cost">
          <label>
            <i class="fa-solid fa-dollar-sign"></i> Total Cost + Fees:
            <input v-model="formData.total_cost" type="number" required class="form-control" placeholder="Total Cost" />
          </label>
        </div>
        <button type="submit" class="btn btn-primary">
          Create Rental <i class="fa-solid fa-circle-arrow-right"></i>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const formData = ref({
  customer_id: '',
  car_id: '',
  rental_date: '',
  return_date: '',
  total_cost: '', // Add this line
});

const createRental = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/rentals', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(formData.value),
    });

    if (response.ok) {
      console.log('Rental created successfully');
      const redirectUrl = response.headers.get('Location');
      if (redirectUrl) {
        // Redirect to the new URL
        router.push(redirectUrl);
      } else {
        // Fallback to the default route if no redirect URL is provided
        router.push('/rentals');
      }
    } else {
      const errorData = await response.json();
      console.error('Error creating rental:', errorData);
    }
  } catch (error) {
    console.error('Error creating rental:', error);
  }
};

const customers = ref([]);
const cars = ref([]);

const fetchCustomers = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/customers');
    const data = await response.json();
    customers.value = data.customers || data;
  } catch (error) {
    console.error('Error fetching customers:', error);
  }
};

const fetchCars = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/cars');
    const data = await response.json();
    cars.value = data;
  } catch (error) {
    console.error('Error fetching cars:', error);
  }
};

onMounted(async () => {
  await fetchCustomers();
  await fetchCars();
});
</script>

<style scoped>
#container {
  margin: auto;
  width: 50%;
  display: flex;
  flex-direction: column;
}

.row {
  width: 100%;
}

.customer_id,
.car_id,
.rental_date,
.return_date,
.total_cost {
  margin-bottom: 15px;
}

form {
  margin-top: 40px;
  border-radius: 15px;
  box-shadow: rgba(0, 0, 0, 0.09) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px,
    rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px,
    rgba(0, 0, 0, 0.09) 0px 32px 16px;
  background-color: white;
  padding: 20px;
}
</style>
