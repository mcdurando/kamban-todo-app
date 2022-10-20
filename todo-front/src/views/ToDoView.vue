<template>
  <!----------------- CREATION ------------------>
  <TopMenu />
  <h1>You can drag and drop any task</h1>
  <div @click="showModalCreation = true" class="add-task">+</div>
  <div>
    <transition name="fade" appear>
      <div
        class="modal-overlay"
        v-if="showModalCreation || showModalEdition"
      ></div>
    </transition>
    <transition name="pop" appear>
      <div
        class="modal myPopup"
        role="dialog"
        v-if="showModalCreation || showModalEdition"
        :style="{
          display: showModalCreation || showModalEdition ? 'block' : 'none',
        }"
      >
        <h4 v-if="showModalCreation">CREATE TASK</h4>
        <h4 v-if="showModalEdition">EDIT TASK</h4>
        <input id="id" type="hidden" class="form-control" v-model="idTask" />
        <input
          id="fname"
          placeholder="Task name"
          class="form-control"
          v-model="task_name"
        />
        <textarea
          placeholder="Description"
          class="form-control"
          v-model="description"
        ></textarea>
        <select class="form-control" v-model="priority">
          <option value="" selected>Select Priority</option>
          <option v-for="(item, i) in priorities" :key="i" :value="item.value">
            {{ item.text }}
          </option>
        </select>
        <input
          id="username"
          placeholder="Duration (days)"
          type="number"
          class="form-control"
          v-model="duration"
        />
        <select class="form-control" v-model="status">
          <option value="" selected>Select Status</option>
          <option v-for="(item, i) in statuss" :key="i" :value="item.value">
            {{ item.text }}
          </option>
        </select>
        <br />
        <!-- ALL BUTTONS -->
        <button class="btn btn-info" @click="saveTask" v-if="showModalCreation">
          Save
        </button>
        <button class="btn btn-info" @click="editTask" v-if="showModalEdition">
          Update
        </button>
        <span v-if="showModalEdition">&nbsp;&nbsp;&nbsp;</span>
        <button
          class="btn btn-danger"
          v-if="showModalEdition"
          @click="confirmDelete"
        >
          Delete
        </button>
        <button
          @click="
            (showModalCreation = false), (showModalEdition = false), resetForm()
          "
          class="btn-close"
        >
          &times;
        </button>
      </div>
    </transition>
  </div>

  <div class="container mt-5 mb-5">
    <div class="row">
      <div class="col mx-2 px-2 py-3 bg-light border rounded myClass">
        <h6>To Do ✍</h6>
        <draggable
          class="draggable-list"
          :list="tasks.todos"
          group="tasks"
          @change="log"
          :move="detectMove"
        >
          <div
            v-for="(item, i) in tasks.todos"
            :key="i"
            v-on:dblclick="showTaskEdition(item)"
          >
            <div class="bg-white mt-3 p-2 shadow border rounded">
              <p>{{ item.description }}</p>
              <p class="task_name">{{ item.task_name }}</p>
              <p class="last_p">
                <span class="myIcon">✍</span>
                <span
                  class="priority"
                  :style="{
                    color:
                      item.priority == 'High'
                        ? 'red'
                        : item.priority == 'Middle'
                        ? '#88db88'
                        : '#00e4ef',
                  }"
                >
                  {{ item.priority }}
                </span>
                <span class="duration">{{ item.duration }} day(s)</span>
                <!-- <span class="assignee">MC</span> -->
              </p>
            </div>
          </div>
        </draggable>
      </div>
      <div class="col mx-2 px-2 py-3 bg-light border rounded myClass">
        <h6>In Progress ⏳</h6>
        <draggable
          class="draggable-list"
          :list="tasks.inProgress"
          group="tasks"
          @change="log"
          :move="detectMove"
        >
          <div
            v-for="(item, i) in tasks.inProgress"
            :key="i"
            v-on:dblclick="showTaskEdition(item)"
          >
            <div class="bg-white mt-3 p-2 shadow border rounded">
              <p>{{ item.description }}</p>
              <p class="task_name">{{ item.task_name }}</p>
              <p class="last_p">
                <span class="myIcon">⏳</span>
                <span
                  class="priority"
                  :style="{
                    color:
                      item.priority == 'High'
                        ? 'red'
                        : item.priority == 'Middle'
                        ? '#88db88'
                        : '#00e4ef',
                  }"
                >
                  {{ item.priority }}
                </span>
                <span class="duration">{{ item.duration }} day(s)</span>
                <!-- <span class="assignee">MC</span> -->
              </p>
            </div>
          </div>
        </draggable>
      </div>
      <div class="col mx-2 px-2 py-3 bg-light border rounded myClass">
        <h6>To be Validate ☝️</h6>
        <draggable
          class="draggable-list"
          :list="tasks.toBeValidate"
          group="tasks"
          @change="log"
          :move="detectMove"
        >
          <div
            v-for="(item, i) in tasks.toBeValidate"
            :key="i"
            v-on:dblclick="showTaskEdition(item)"
          >
            <div class="bg-white mt-3 p-2 shadow border rounded">
              <p>{{ item.description }}</p>
              <p class="task_name">{{ item.task_name }}</p>
              <p class="last_p">
                <span class="myIcon">☝️</span>
                <span
                  class="priority"
                  :style="{
                    color:
                      item.priority == 'High'
                        ? 'red'
                        : item.priority == 'Middle'
                        ? '#88db88'
                        : '#00e4ef',
                  }"
                >
                  {{ item.priority }}
                </span>
                <span class="duration">{{ item.duration }} day(s)</span>
                <!-- <span class="assignee">MC</span> -->
              </p>
            </div>
          </div>
        </draggable>
      </div>
      <div class="col mx-2 px-2 py-3 bg-light border rounded myClass">
        <h6>Done ✅</h6>
        <draggable
          class="draggable-list"
          :list="tasks.done"
          group="tasks"
          @change="log"
          :move="detectMove"
        >
          <div
            v-for="(item, i) in tasks.done"
            :key="i"
            v-on:dblclick="showTaskEdition(item)"
          >
            <div class="bg-white mt-3 p-2 shadow border rounded">
              <p>{{ item.description }}</p>
              <p class="task_name">{{ item.task_name }}</p>
              <p class="last_p">
                <span class="myIcon">✅</span>
                <span
                  class="priority"
                  :style="{
                    color:
                      item.priority == 'High'
                        ? 'red'
                        : item.priority == 'Middle'
                        ? '#88db88'
                        : '#00e4ef',
                  }"
                >
                  {{ item.priority }}
                </span>
                <span class="duration">{{ item.duration }} day(s)</span>
                <!-- <span class="assignee">MC</span> -->
              </p>
            </div>
          </div>
        </draggable>
      </div>
    </div>
  </div>
</template>

<script>
// import draggable from "vuedraggable";
import { VueDraggableNext } from "vue-draggable-next";
import TopMenu from "@/components/TopMenu.vue";
import TaskService from "../services/TaskService";
import GeneralService from "../services/GeneralService";

export default {
  name: "ToDoView",
  components: {
    draggable: VueDraggableNext,
    TopMenu,
  },
  data() {
    return {
      // Task data //
      idTask: "",
      task_name: "",
      description: "",
      status: "",
      duration: 0,
      priority: "",

      countRunRefresh: 0,
      // End task data //

      userId: localStorage.getItem("idUser"),
      showModalCreation: false,
      showModalEdition: false,
      statuss: [
        {
          value: "not-start",
          text: "Not yet Start",
        },
        {
          value: "in-progress",
          text: "In Progress",
        },
        {
          value: "to-be-validate",
          text: "To Be Validate",
        },
        {
          value: "done",
          text: "Done",
        },
      ],
      priorities: [
        {
          value: "High",
          text: "High",
        },
        {
          value: "Middle",
          text: "Middle",
        },
        {
          value: "Low",
          text: "Low",
        },
      ],
      assignee: [],
      allTasks: [],
      tasks: {
        todos: [],
        inProgress: [],
        toBeValidate: [],
        done: [],
      },
    };
  },

  created() {
    this.idUser = localStorage.getItem("idUser");
    // Show loader
    GeneralService.showLoader();
    this.retrieveAllTasks();
  },

  methods: {
    // --------- Add new task -----------//
    resetForm() {
      this.idTask = "";
      this.task_name = "";
      this.description = "";
      this.status = "";
      this.duration = "";
      this.priority = "";
      console.log("++");
    },
    deleteTask() {
      // Show loader
      GeneralService.showLoader();
      // Close modal
      this.showModalEdition = false;
      TaskService.delete(this.idTask).then((response) => {
        console.log(response);

        //--------------//
        this.showAlert("success", "The task has been deleted successfully !");

        // Reset form
        this.resetForm();

        // Refresh all tasks
        this.retrieveAllTasks();
      });
    },
    editTask() {
      var data = {
        task_name: this.task_name,
        description: this.description,
        status: this.status,
        duration: this.duration,
        priority: this.priority,
        assignee: this.idUser,
      };

      // Show loader
      GeneralService.showLoader();

      // Close modal
      this.showModalEdition = false;

      console.log("2---------", data);

      TaskService.update(this.idTask, data)
        .then((response) => {
          //--------------//
          this.showAlert("success", "The task has been updated successfully !");

          // this.tutorial.id = response.data.id;
          console.log("++++++++++++++updated++++++++++++++++");
          console.log(response.data);
          // this.submitted = true;

          // Reset form
          this.resetForm();

          // Refresh all tasks
          this.retrieveAllTasks();
        })
        .catch((e) => {
          console.log(e);
        });
    },

    showAlert(icon, text) {
      ///-----------------------/////
      this.$swal.fire({
        icon: icon,
        text: text,
      });
    },

    confirmDelete() {
      this.$swal
        .fire({
          title: "Are you sure to delete this task?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            // Run delete
            this.deleteTask();
          }
        });
    },
    saveTask() {
      var data = {
        task_name: this.task_name,
        description: this.description,
        status: this.status,
        duration: this.duration,
        priority: this.priority,
        assignee: this.idUser,
      };

      // Show loader
      GeneralService.showLoader();

      // Close modal
      this.showModalCreation = false;

      console.log("1---------", data);

      TaskService.create(data)
        .then((response) => {
          console.log("----SAVE ----", response);

          //--------------//
          this.showAlert("success", "The task has been created successfully !");

          // Reset form
          this.resetForm();

          // Refresh all tasks
          this.retrieveAllTasks();
        })
        .catch((e) => {
          console.log(e);
        });
    },
    // ----- Retrieve all tasks ------//
    retrieveAllTasks() {
      TaskService.getAll(this.idUser)
        .then((response) => {
          setTimeout(() => {
            // Hide loader
            GeneralService.hideLoader();
          }, 500);

          this.allTasks = response.data.data;

          // Dispatch All Tasks
          this.dispatchAllTasks();

          console.log("---------------- AZERTY ----------------");
          console.log(response.data);
          console.log("----------->", this.tasks.todos);
        })
        .catch((e) => {
          console.log(e);
        });
    },

    // Filter task
    dispatchAllTasks() {
      this.tasks.todos = this.allTasks.filter(
        (item) => item.status == "not-start"
      );
      this.tasks.inProgress = this.allTasks.filter(
        (item) => item.status == "in-progress"
      );
      this.tasks.toBeValidate = this.allTasks.filter(
        (item) => item.status == "to-be-validate"
      );
      this.tasks.done = this.allTasks.filter((item) => item.status == "done");
    },

    log() {
      // --------------------- Update all tasks  -------------------- \\

      // Run loader
      GeneralService.showLoader();

      // Increment
      this.countRunRefresh++;

      // 2nd refresh
      if (this.countRunRefresh == 2) {
        let todos = this.tasks.todos;
        for (let i = 0; i < todos.length; i++) {
          todos[i]["status"] = "not-start";
        }

        let inProgress = this.tasks.inProgress;
        for (let i = 0; i < inProgress.length; i++) {
          inProgress[i]["status"] = "in-progress";
        }

        let toBeValidate = this.tasks.toBeValidate;
        for (let i = 0; i < toBeValidate.length; i++) {
          toBeValidate[i]["status"] = "to-be-validate";
        }

        let done = this.tasks.done;
        for (let i = 0; i < done.length; i++) {
          done[i]["status"] = "done";
        }

        console.log("To do ===> ", this.tasks.todos);
        console.log("In progress ===> ", this.tasks.inProgress);
        console.log("To be validate ===> ", this.tasks.toBeValidate);
        console.log("Done ===> ", this.tasks.done);
        console.log("-------------------------------------------------");

        let allTasksUpdated = [
          ...todos,
          ...inProgress,
          ...toBeValidate,
          ...done,
        ];

        TaskService.updateAllTasks(allTasksUpdated).then((res) => {
          // Run loader
          GeneralService.hideLoader();
          console.log("/////////////////////", res);
        });

        // Reset
        this.countRunRefresh = 0;
      }
    },
    detectMove() {},

    showTaskCreation() {},

    showTaskEdition(data) {
      this.showModalEdition = true;

      // Remplir les formulaires
      this.idTask = data.id;
      this.task_name = data.task_name;
      this.description = data.description;
      this.priority = data.priority;
      this.duration = data.duration;
      this.status = data.status;

      console.log("//////////////////", data.status);
    },
  },
};
</script>

<style lang="scss" scoped>
h6 {
  font-weight: 700;
}
.col {
  height: 90vh;
  overflow: auto;
}
.draggable-list {
  min-height: 10vh;
}
.draggable-list > div {
  cursor: pointer;
}
.myClass {
  text-align: left;
  background: #e8e8e8 !important;

  .task_name {
    padding: 5px;
    background: #e9b417;
    font-weight: bold;
    border-radius: 3px;
    display: inline-block;
  }

  .last_p {
    font-weight: bold;
    .assignee {
      padding: 5px;
      float: right;
      background: aqua;
      border-radius: 50%;
    }
    .priority,
    .myIcon {
      margin-right: 10px;
    }
  }
}

.myBtn {
  padding: 5px;
  border: none;

  color: wheat;
  border-radius: 5px;
  margin: 15px;

  .btn_update {
    background: green;
  }

  .btn_delete {
    background: red;
  }
}

/*************** MODAL  ************/

.button {
  border: none;
  color: #fff;
  background: #42b983;
  appearance: none;
  font: inherit;
  font-size: 1.8rem;
  padding: 0.5em 1em;
  border-radius: 0.3em;
  cursor: pointer;
}

.modal {
  position: absolute;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  margin: auto;
  text-align: center;
  width: fit-content;
  height: fit-content;
  max-width: 22em;
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2);
  background: #fff;
  z-index: 999;
  transform: none;
}
.modal h1 {
  margin: 0 0 1rem;
}

.modal-overlay {
  content: "";
  position: absolute;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 998;
  background: #2c3e50;
  opacity: 0.6;
  cursor: pointer;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s linear;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.pop-enter-active,
.pop-leave-active {
  transition: transform 0.4s cubic-bezier(0.5, 0, 0.5, 1), opacity 0.4s linear;
}

.pop-enter,
.pop-leave-to {
  opacity: 0;
  transform: scale(0.3) translateY(-50%);
}
</style>