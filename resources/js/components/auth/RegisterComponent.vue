<template>
  <div class="container">
      <div class="row vh-100 justify-content-center align-items-center">
          <div class="col-md-6">
            <div v-if="success" class="d-flex justify-content-center my-2">
              <button class="btn btn-success text-white" type="button" disabled>
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                Идет переадресация
              </button>
            </div>
              <div class="card">
                  <div class="card-header text-center"><h3>Регистрация</h3></div>

                  <div class="card-body">
                      <div v-if="success" class="alert alert-success" role="alert">
                        {{message}}
                      </div>
                      <form class="form-signin" novalidate>
                        <div class="form-floating mb-3">
                          <input @blur="$v.form.login.$touch()"
                                 :class="status($v.form.login)"
                                 v-model="form.login"
                                 id="login" type="text" class="form-control" aria-describedby="loginHelp" placeholder="xenon">
                          <label for="email"><i class="bi bi-envelope-fill"></i> Ваш Ник</label>
                          <div class="invalid-feedback" v-if="!$v.form.login.required">{{ reqText }}</div>
                          <div v-if="errors && errors.login" class="text-danger">{{ errors.login[0] }}</div>
                        </div>
                        <div class="form-floating mb-3">
                          <input @blur="$v.form.email.$touch()"
                                 :class="status($v.form.email)"
                                 v-model="form.email"
                                 id="email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="name@example.com">
                          <label for="email"><i class="bi bi-envelope-fill"></i> Ваш E-mail</label>
                          <div class="invalid-feedback" v-if="!$v.form.email.required">{{ reqText }}</div>
                          <div class="invalid-feedback" v-if="!$v.form.email.email">Пожалуйста введите Email адрес</div>
                          <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                        </div>
                        <div class="form-floating mb-3">
                          <input @blur="$v.form.password.$touch()"
                                 :class="status($v.form.password)"
                                 v-model="form.password"
                                 id="password" type="password" class="form-control"placeholder="Новый пароль">
                          <label for="password"><i class="bi bi-key-fill"></i> Ваш новый пароль</label>
                          <div class="invalid-feedback" v-if="!$v.form.password.required">{{ reqText }}</div>
                          <div class="invalid-feedback" v-if="!$v.form.password.minLength">{{minLengthText}}</div>
                          <div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>
                        </div>
                        <div class="form-floating mb-3">
                          <input @blur="$v.form.password_confirmation.$touch()"
                                 :class="status($v.form.password_confirmation)"
                                 v-model="form.password_confirmation"
                                 id="password_confirmation" type="password" class="form-control" placeholder="Новый пароль">
                          <label for="password_confirmation"><i class="bi bi-key-fill"></i> Подвердить новый пароль</label>
                          <div class="invalid-feedback" v-if="!$v.form.password_confirmation.sameAs">{{passwordConfirmText}}</div>
                          <div v-if="errors && errors.password_confirmation" class="text-danger">{{ errors.password_confirmation[0] }}</div>
                        </div>
                        <div class="d-grid gap-2 mb-1">
                          <button @click.prevent="sendLink" type="submit" class="btn btn-block btn-primary text-white">
                              Зарегестрироваться
                          </button>
                        </div>

                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
    import {required, email, minLength, sameAs, helpers} from 'vuelidate/lib/validators'
    const alpha = helpers.regex('alpha', /^[а-яёА-ЯЁ ]*$/)
    export default {
        mounted() {
            console.log('Компонент загружен')
        },
        data() {
            return {
                errors: [],
                success: false,
                message: '',
                reqText: 'Поле обязательно для заполнения',
                minLengthText: 'Минимальная длина 6 символов!',
                passwordConfirmText: 'Пароли не совпадают',
                form: {
                  login: '',
                  email: '',
                  password: '',
                  password_confirmation: '',
                },
                phoneTokens: {
                  '#': {
                    pattern: /\d/
                  },
                  '!': {escape: true}
                },
            }
        },
        methods:{
          status(validation) {
             return {
               'is-invalid': validation.$error,
               'is-valid': !validation.$error && validation.$dirty,
             }
          },
          sendLink(){
            if(this.$v.form.$invalid){
              this.$v.form.$touch()
            }else{
              axios.post('/register', this.form).then((response) =>{
                this.errors = []
                this.form.email = ''
                this.success = true
                this.message = 'Вы успешно прошли регистрацию!'
                // убрать сообщение о регистрации
                setTimeout(() => {
                  this.success = false
                  this.message = ''
                  location.href = '/login'
                }, 3000)

                // сбросить все поля
                for (let input in this.form) {
                    this.form[input] = ''
                }
                this.$v.form.$reset()
              }).catch((error) =>{
                  this.errors = error.response.data.errors
              })
            }


         }
        },
        validations: {
            form: {
                login: {
                  required
                },
                email: {
                  email,
                  required
                },
                password: {
                  required,
                  minLength: minLength(6)
                },
                password_confirmation: {
                  required,
                  sameAs: sameAs('password')
                },
            }
        },
    }
</script>
