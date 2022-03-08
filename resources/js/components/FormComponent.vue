<template>
  <div class="content">
      <div v-if="done">
            <div class="alert alert-success">
                {{done}}
            </div>
      </div>
      <div v-else-if="errors.length != 0">
            <div class="alert alert-danger">
                <ul class="d-inline-block mb-0">
                    <li v-for="(error, i) in errors" :key="i"> {{error}} </li>
                </ul>
            </div>
      </div>

      

      <form class="row g-3 needs-validation" @submit.prevent="onFormSubmit">
        <div class="col-md-4">
            <label for="name-field" class="form-label">Name</label>
            <input type="text" class="form-control" id="name-field" name="name" v-model="input.name" required placeholder="Insert your name">
        </div>
        <div class="col-md-4">
            <label for="last-name-field" class="form-label">Last name</label>
            <input type="text" class="form-control" id="last-name-field" name="last_name" v-model="input.last_name" required placeholder="Insert your last name">
        </div>
        <div class="col-md-4">
            <label for="email-field" class="form-label">Email</label>
            <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="text" class="form-control" id="email-field" name="email" v-model="input.email" required placeholder="e.g. mario.rossi@gmail.com">
                <div class="invalid-feedback">
                    Please insert a valid email address.
                </div>
            </div>
        </div>
        <div class="col-12 mt-5">
            <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
    </form>
  </div>
</template>

<script>
export default {
    //components: {FormComponent},
    data() {
        return {
            input: {},
            errors: [],
            done: ''
        };
    },
    methods: {
        onFormSubmit(){
            window.axios.post('/api/store', this.input).then((resp) => {
                //console.log(resp.data);

                if(resp.data.success === false) {
                    let errorMsgs = [];
                    for (const key in this.input) {
                        //console.log(resp.data.data[key]);
                        if (resp.data.data[key]) {
                            errorMsgs.push(resp.data.data[key])
                        }
                    }
                    this.done = '';
                    throw new Error(errorMsgs);
                } else {
                    this.done = 'Data saved successfully!'
                    this.errors = []
                    this.input = {}
                }


            }).catch((error) => {
                this.errors = error.message.split(',')
                
            })
        }
    }
}
</script>

<style>

</style>