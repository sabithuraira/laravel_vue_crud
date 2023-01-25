<template>
    <main>

        <div class="input-group">
            <input type="text" class="form-control" name="search" v-model="keyword" v-on:keyup.enter="getList()" placeholder="Search..">
        </div>
        <br/>

        <button type="button" class="btn btn-primary" @click="addProduct">+ Add Product</button>
        <br/><br/>

        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th colspan="2">Action</th>
            </tr>

            <tr v-for="(data, idx) in datas.data" :key="data.encId">
                <td>{{ idx + 1}}</td>
                <td>{{ data.product_name }}</td>
                <td>{{ data.quantity }}</td>
                <td>{{ data.price }}</td>
                <td><button type="button" class="btn btn-primary" @click="editProduct(data)">Edit</button></td>
                <td><button type="button" class="btn btn-danger" @click="deleteProduct(data.encId)">Delete</button></td>
            </tr>
        </table>
                            
        <template v-if="datas.data.length>0">
            <Bootstrap4Pagination
                :data="datas"
                @pagination-change-page="getList"
            />
        </template>

        <div class="modal" id="form-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><span style="color: red; display:block; float:right">*</span>Title</label>
                            <input type="text" v-model="form_data.product_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label><span style="color: red; display:block; float:right">*</span>Price</label>
                            <input type="number" v-model="form_data.price" class="form-control">
                        </div>

                        <div class="form-group">
                            <label><span style="color: red; display:block; float:right">*</span>Quantity</label>
                            <input type="number" v-model="form_data.quantity" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="saveProduct">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
  </main>
</template>

<script>
    import axios from 'axios'
    import $ from 'jquery'
    import { Bootstrap4Pagination } from 'laravel-vue-pagination';

    export default {
        data() {
            return {
                keyword: '',
                datas: {
                    data: []
                },
                form_data: {
                    encId: '',
                    product_name: '',
                    price: '',
                    quantity: '',
                },
                urlApi: this.urlApi
            }
        },
        components:{ 
            Bootstrap4Pagination,
        },
        methods : {
            async getList(page=1){
                await axios
                    .get(`${this.urlApi}product?page=${page}`,
                        {   
                            params: { keyword: this.keyword, }
                        })
                    .then(({data})=>{
                        this.datas = data.results
                    }).catch(({ response })=>{
                        console.error(response)
                    })
            },
            emptyForm(){
                this.form_data = {
                    encId: '',
                    product_name: '',
                    price: '',
                    quantity: '',
                };
            },
            addProduct(){
                this.emptyForm();
                $("#form-product").modal('show');
            },
            editProduct(productObj){
                this.form_data = {
                    encId: productObj.encId,
                    product_name:  productObj.product_name,
                    quantity:  productObj.quantity,
                    price:  productObj.price,
                };
                $("#form-product").modal('show');
            },
            saveProduct(){
                let errorMsg = [];

                if(this.form_data.product_name=='') errorMsg.push("Product name is required");
                if(this.form_data.price=='') errorMsg.push("Price is required");
                if(this.form_data.quantity=='') errorMsg.push("Quantity is required");

                if(errorMsg.length>0){
                    alert(errorMsg.join(","));
                }
                else{
                    if(this.form_data.encId==''){
                        axios
                            .post(this.urlApi + 'product', {
                                product_name: this.form_data.product_name,
                                quantity: this.form_data.quantity,
                                price: this.form_data.price,
                            })
                            .then(({ data }) => {
                                if(data.status=="success"){
                                    this.emptyForm();
                                    this.getList()
                                    $('#form-product').modal('hide');
                                    alert("Data already saved")
                                }
                                else{
                                    console.log(data)
                                    $('#form-product').modal('hide');
                                }
                            })
                    }
                    else{
                        axios
                            .patch(this.urlApi + 'product/' + this.form_data.encId, {
                                product_name: this.form_data.product_name,
                                quantity: this.form_data.quantity,
                                price: this.form_data.price,
                            })
                            .then(({ data }) => {
                                if(data.status=="success"){
                                    this.emptyForm();
                                    this.getList()
                                    $('#form-product').modal('hide');
                                    alert("Data already saved")
                                }
                                else{
                                    console.log(data)
                                    $('#form-product').modal('hide');
                                }
                            })
                    }
                }
            },
            deleteProduct(encId){
                if(confirm("Are you sure want to delete this data?")){
                    axios
                        .delete(this.urlApi + 'product/' + encId)
                        .then(({ data }) => {
                            if(data.status=="success"){
                                this.getList()
                                alert("Data already deleted")
                            }
                            else{
                                console.log(data)
                            }
                        })
                }
            }
        },
        created() {
            this.getList();
        }
    }
</script>