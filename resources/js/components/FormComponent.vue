<template>
  <div>
      <div v-if="done">
            <div class="alert alert-success">
                {{done}}
            </div>
      </div>
      <div v-else-if="errors.length != 0">
            <div class="alert alert-danger">
                <ul class="d-inline-block">
                    <li v-for="(error, i) in errors" :key="i"> {{error}} </li>
                </ul>
            </div>
      </div>

      

      <form class="row g-3 needs-validation" @submit.prevent="onFormSubmit">
        <div class="col-md-4">
            <label for="validationCustom01" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" v-model="input.name" required>
        </div>
        <div class="col-md-4">
            <label for="validationCustom02" class="form-label">Last name</label>
            <input type="text" class="form-control" name="last_name" v-model="input.last_name" required>
        </div>
        <div class="col-md-4">
            <label for="validationCustomUsername" class="form-label">Email</label>
            <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="text" class="form-control" name="email" v-model="input.email" required>
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