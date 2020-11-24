<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form @submit.prevent="onSubmit(email, password)">
                            <div class="form-group">
                                <label for="email" class="col-form-label text-md-right">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" v-model="email" required autocomplete="email" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-md-right">Password</label>
                                <input id="password" type="password" class="form-control" name="password" v-model="password" required autocomplete="current-password">
                            </div>
                            <div class="form-group mt-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
  name: 'login',
  data() {
    return {
      email: null,
      password: null
    };
  },
  methods: {
    async onSubmit(email, password) {
        const {data} = await axios.post('http://dev-laravel.sjahn.gtz.kr/api/user/login', {
            email,
            password
        })

        console.log(data);
        /*
        if (data.err !== 0){
            alert(data.msg)
            window.location.href = data.url
        } else {
            console.log('test');
        }
        */
    },
    
  },
};
</script>