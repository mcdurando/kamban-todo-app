import http from "../http-common";
class TaskService {
  getAll(id) {
    return http.get(`/tasks/${id}`);
  }
//   get(id) {
//     return http.get(`/tasks/${id}`);
//   }
  create(data) {
    return http.post("/tasks", data);
  }
  update(id,data) {
    return http.put(`/tasks/${id}`, data);
  }
  delete(id) {
    return http.delete(`/tasks/${id}`);
  }

  updateAllTasks(data){
      return http.post("/updateAllTasks",data);
  }
//   deleteAll() {
//     return http.delete(`/tasks`);
//   }
//   findByTitle(title) {
//     return http.get(`/tutorials?title=${title}`);
//   }
}

export default new TaskService();