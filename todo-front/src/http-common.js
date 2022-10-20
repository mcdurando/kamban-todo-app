import axios from "axios";
export default axios.create({
  baseURL: "https://mc-todo-list-back.herokuapp.com/api",
  headers: {
    "Content-type": "application/json"
  }
});