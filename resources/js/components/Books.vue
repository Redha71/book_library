<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Book List</div>

          <div class="card-body">
            <table>
              <thead>
                <tr>
                  <td>Title</td>
                  <td>Auther</td>
                  <td>Publication Year</td>
                  <td>Number of pages</td>
                  <td>Action</td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in books" :key="index">
                  <td>{{ item.title }}</td>
                  <td>{{ item.author }}</td>
                  <td>{{ item.publication_year }}</td>
                  <td>{{ item.number_of_pages }}</td>
                  <td v-if="item.loan_start_date != null">
                    <a :href="'/borrowe/' + item.id" class="btn btn-button notcan">Borrowed</a>
                  </td>
                  <td v-else><span class="can">Can Borrowed</span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-body">
            <br />
            <br />
            <h3>Add New Book</h3>
            <form @submit.prevent="addBook">
              <div class="form-group">
                <label for="title">Book Title</label>
                <input
                  type="text"
                  class="form-control"
                  name="title"
                  id="title"
                  v-model="newBook.title"
                  required
                />
              </div>
              <div class="form-group">
                <label for="author">Auther</label>
                <input
                  type="text"
                  class="form-control"
                  name="author"
                  id="author"
                  v-model="newBook.author"
                  required
                />
              </div>
              <div class="form-group">
                <label for="publication_year">Publication Year</label>
                <input
                  type="number"
                  class="form-control"
                  name="publication_year"
                  id="publication_year"
                  v-model="newBook.publication_year"
                  required
                />
              </div>
              <div class="form-group">
                <label for="number_of_pages">Number Of Pages</label>
                <input
                  type="number"
                  class="form-control"
                  name="number_of_pages"
                  id="number_of_pages"
                  v-model="newBook.number_of_pages"
                  required
                />
              </div>
              <button type="submit" class="btn btn-primary">Save Book</button>
            </form>
          </div>
          <div class="card-body">
            <br />
            <br />
            <h3>Borrowe Book</h3>
            <form @submit.prevent="brroweBook">
              <div class="form-group">
                <label for="title">Book Title</label>
                <select class="form-control" name="book_id" v-model="borrowe.book_id" required>
                   <option v-for="(item, index) in books" :key="index" v-bind:value="item.id">
                    {{ item.title }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label for="borrower_name">Auther</label>
                <input
                  type="text"
                  class="form-control"
                  name="borrower_name"
                  id="borrower_name"
                  v-model="borrowe.borrower_name"
                  required
                />
              </div>
              <button type="submit" class="btn btn-primary">
                Borrowe Book
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      books: [],
      newBook: {},
      borrowe:{}
    };
  },
  created() {
    this.getBooksList();
  },
  methods: {
    // ini()
    getBooksList() {
        // get all book list
      axios
        .get("/books")
        .then((response) => {
          this.books = response.data.books;
        })
        .catch((error) => {
          // error.response.status Check status code
        });
    },

    addBook() {
        // send new book information
      axios
        .post("/store", this.newBook)
        .then((response) => {
          alert("Book Save!");
          this.books = response.data.books;
        })
        .catch((error) => {
          // error.response.status Check status code
        });
    },
    brroweBook() {
        // borrowe book with name
      axios
        .post("/borrowebook", this.borrowe)
        .then((response) => {
          alert("Borrowed Book!");
          this.books = response.data.books;
        })
        .catch((error) => {
          // error.response.status Check status code
        });
    },
  },
};
</script>
<style>
table,
th,
td {
  border: 1px solid black;
}
input,select {
  border: solid 1px gray;
  padding-right: 10px;
  outline: solid 1px silver;
}
.can {
  color: black;
}
.notcan {
  color: red;
}
a{
    display: block;

    width: auto;
background-color: aqua;
    border: 1px solid #000;
}
</style>