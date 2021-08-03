<template>
    <div>
      <Loader v-if="loader"/>

      <div v-else>
        <transition name="slide-fade">
          <div v-if="createMessage" class="alert alert-success" role="alert">
             Операция прошла успешно!
          </div>
        </transition>

        <transition name="slide-fade">
          <div>
            <div class="input-group mb-1">
              <input  v-model="searchItem" v-on:keyup="searchInTheList(searchItem)"
                      type="text" class="form-control" placeholder="Поиск" aria-label="Поиск объекта" aria-describedby="clear">
              <button v-on:click="clearSearchItem" :class="{'disabled': searchItem==''}"
                      class="btn btn-outline-secondary" type="button">Очистить</button>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-borderless align-middle">
                <tbody>
                  <tr v-for="item in paginatedItems" :key="item.id" :class="statusItem(item.id)" @click="selectItem(item)">
                    <th class="rounded-start" scope="row">{{item.id}}</th>
                    <td>{{item.title}}</td>
                    <td>{{item.description}}</td>
                    <td>{{item.data}}</td>
                    <td class="text-end rounded-end">

                    </td>
                  </tr>
                  <tr v-if="noResult" class="bg-danger">
                    <td class="rounded-start text-white h5">К сожелению, по результату поиска ничего не найдено... Попробуйте еще.</td>
                    <td class="text-end rounded-end">
                      <button class="btn btn-light" type="button" @click="clearSearchItem">
                        Очистить
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-center">
              <nav aria-label="...">
                <ul class="pagination">
                  <li class="page-item"
                      :class="{'disabled': pagination.currentPage == pagination.items[0] || pagination.items.length==0}">
                      <a @click="selectPage(pagination.currentPage-1)"
                          class="page-link">Назад</a>
                  </li>
                  <li v-for="item in pagination.filteredItems"
                      :class="{'active': item == pagination.currentPage}"
                      @click="selectPage(item)"
                      class="page-item"><a class="page-link">{{item}}</a></li>

                  <li class="page-item" :class="{'disabled': pagination.currentPage==pagination.items[pagination.items.length-1] || pagination.items.length==0}">
                    <a @click="selectPage(pagination.items[pagination.items.length-1])"
                        class="page-link">Вперед</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </transition>

      </div>
    </div>
</template>

<script>
    import SearchPaginationMixin from '../mixins/SearchPagination.mixin.js'
    export default {
      props: ['type'],
      data() {
          return {
            createMessage: false,
            loader: true,
            id: null,
          }
      },
      mounted() {
        console.log('Компонент успешно загружен. '+this.type)
        this.getData()
      },
      mixins: [SearchPaginationMixin],
      methods: {
        getData(){
          if(this.type === 'chats'){
            this.getChats()
          }
        },
        getChats(){
          axios.post('/api/get-chats').then((response) =>{
            this.items = response.data

            this.filteredItems = this.items
            this.buildPagination()
            this.selectPage(1)
            this.loader = false
          })
        },
        getLogs(){
          axios.post('/api/get-cars',{id : this.project, type: this.passType}).then((response) =>{
            this.items = response.data

            if(this.items.length < 2){
              this.id = this.items[0].id
              this.$emit('checkItem', this.id);
            }
            this.filteredItems = this.items
            this.buildPagination()
            this.selectPage(1)

            this.loader = false
          })
        },
        getProfiles(){
          axios.post('/api/get-profiles',{id : this.project}).then((response) =>{
            this.items = response.data

            if(this.items.length < 2){
              this.id = this.items[0].id
              this.$emit('checkItem', this.id);
            }
            this.filteredItems = this.items
            this.buildPagination()
            this.selectPage(1)

            this.loader = false
          })
        },
        getMechanizms(){
          axios.post('/api/get-mechanizms',{id : this.project}).then((response) =>{
            this.items = response.data

            if(this.items.length < 2){
              this.id = this.items[0].id
              this.$emit('checkItem', this.id);
            }
            this.filteredItems = this.items
            this.buildPagination()
            this.selectPage(1)

            this.loader = false
          })
        },
        getApplicants(){
          if(this.project){
            axios.post('/api/get-applicants',{id : this.project }).then((response) =>{
              this.items = response.data

              if(this.items.length < 2){
                this.id = this.items[0].id
                this.$emit('checkItem', this.id);
              }
              this.filteredItems = this.items
              this.buildPagination()
              this.selectPage(1)

              this.loader = false
            })
          }
        },
        statusItem(id){
          return {
            'bg-success': id === this.id,
            'bg-info': id != this.id
          }
        },
        selectItem(item){
          if(this.id == null || this.id != item.id){
            this.id = item.id
          }else{
            this.id = null
          }

          this.$emit('checkItem', this.id);
        },
        refreshList(data){
          this.getData()
          this.search = true
          this.noResult = false
          this.id = data.id
          this.searchItem = data.title
          setTimeout(() => {
            this.searchInTheList(data.title)
          }, 1000)
          this.createMessage = true;
          // убрать сообщение о регистрации
          setTimeout(() => {
            this.createMessage = false
          }, 5000)
          this.$emit('checkItem', this.id);
        },
      },
    }
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.5s ease;
}
.slide-fade-enter {
  transform: translateX(10px);
  opacity: 0;
}
.table{
  border-collapse: separate!important;
  border-spacing: 0 5px;
  cursor: pointer;
}
</style>
