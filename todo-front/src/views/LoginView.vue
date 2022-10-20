<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6 mt-4">
        <h2>Sign In</h2>
        <p class="text-danger" v-if="error">
          {{ error }}
        </p>
        <form @submit.prevent="login">
          <div class="form-group">
            <label for="email">Email Address: </label>
            <input
              type="email"
              class="form-control"
              id="email"
              v-model="form.email"
            />
          </div>
          <div class="form-group">
            <label for="password">Password: </label>
            <input
              type="password"
              class="form-control"
              id="password"
              v-model="form.password"
            />
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
          <br /><br />
          <span
            >Don't have any account , please
            <router-link href="" :to="{ name: 'register' }"
              >Sign Up</router-link
            ></span
          >
        </form>
      </div>
    </div>
  </div>
</template>


<script>
// @ is an alias to /src

import { reactive, ref } from "vue";
import http from "../http-common";
import { useRouter } from "vue-router";

import GeneralService from "../services/GeneralService";

export default {
  name: "LoginView",
  components: {},
  setup() {
    const router = useRouter();

    let form = reactive({
      email: "",
      password: "",
    });

    let error = ref("");
    const login = async () => {
      // Show loader
      GeneralService.showLoader();

      await http.post("login", form).then((res) => {

        // Hide loader
        GeneralService.hideLoader();

        console.log("----------- AHOANAAAAAAAAA ---------------");
        console.log(res.data);
        if (res.data.success) {
          console.log("SUCCESS");

          // Set data
          localStorage.setItem("token", res.data.data.token);
          localStorage.setItem("idUser", res.data.data.idUser);

          // Go to task page
          router.push({ name: "toDo" });
        } else {
          error.value = res.data.message;
        }
      });
    };
    return {
      form,
      login,
      error,
    };
  },
};
</script>
<style scoped>
form {
  text-align: left;
  border: 1px solid white;
  border-radius: 5px;
  padding: 18px;
}
</style>
