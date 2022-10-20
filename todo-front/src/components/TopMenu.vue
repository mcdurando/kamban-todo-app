
  <template>
  <div class="home"  style="text-align : right">
    <nav>
      <span @click="logOut"><a href="#">Log out</a></span>
    </nav>
  </div>
</template>

<script>
export default {
  name: "TopMenu",
  methods: {
    logOut() {
      localStorage.removeItem("token");
      localStorage.removeItem("idUser");
      this.$router.push("/");
    },
  },
};
</script>