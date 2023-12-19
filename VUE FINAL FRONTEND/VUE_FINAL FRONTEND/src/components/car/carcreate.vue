<template>
    <div class="row">
      <div id="container" class="col-md-5">
        <form @submit.prevent="createCar">
          <div class="brand">
            <label>
              <i class="fa-solid fa-car"></i> Brand:
              <input
                v-model="formData.brand"
                required
                class="form-control"
                placeholder="Brand"
              />
            </label>
          </div>
          <div class="model">
            <label>
              <i class="fa-solid fa-car"></i> Model:
              <input
                v-model="formData.model"
                required
                class="form-control"
                placeholder="Model"
              />
            </label>
          </div>
          <div class="year">
            <label>
              <i class="fa-solid fa-calendar"></i> Car Year:
              <input
                v-model="formData.year"
                required
                class="form-control"
                placeholder="Year"
              />
            </label>
          </div>
          <div class="rental_rate">
            <label>
              <i class="fa-solid fa-dollar-sign"></i> Rental Rate:
              <input
                v-model="formData.rental_rate"
                required
                class="form-control"
                placeholder="Rental Rate"
              />
            </label>
          </div>
          <button type="submit" class="btn btn-primary">
            Create Car <i class="fa-solid fa-circle-arrow-right"></i>
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from "vue";
  import { useRouter } from "vue-router";
  
  const router = useRouter();
  
  const formData = ref({
    brand: "",
    model: "",
    year: "",
    rental_rate: "",
  });
  
  const createCar = async () => {
    try {
      const response = await fetch("http://localhost:8000/api/cars", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData.value),
      });
  
      if (response.ok) {
        console.log("Car created successfully");
        router.push("/cars");
      } else {
        console.error("Error creating car:", response.statusText);
      }
    } catch (error) {
      console.error("Error creating car:", error);
    }
  };
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
  
  .brand,
  .model,
  .year,
  .rental_rate {
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
  