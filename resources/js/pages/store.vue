<template>
    <div class="card">
        <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
        <div class="card-body">

            <div v-if="ShowForm">
                <div class=" d-flex justify-content-end">
                    <button type="button" class="btn btn-success me-2" @click="SaveStore()"
                        :disabled="CheckForm">ບັນທຶກ</button>
                    <button type="button" class="btn btn-secondary" @click="CancelStore()">ຍົກເລີກ</button>
                </div>
                {{ FormStore }}
                <hr>
                <div class="row">
                    <!-- <div class=" col-md-4 text-center" style=" position: relative;">
                        <button type="button" class="btn rounded-pill btn-icon btn-danger"
                            style="position: absolute;right: 0px;">
                            <i class='bx bxs-x-circle fs-4'></i>
                        </button>
                        <img :src="image_pre" class=" rounded cursor-pointer" style=" width: 80%;" alt="">
                        <input type="file" ref="img_store" style=" display: none;">
                    </div> -->
                    <div class=" col-md-8">

                        <div>
                            <label class="form-label fs-6">ຊື່ສິນຄ້າ: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mb-2" v-model="FormStore.name" placeholder=".....">
                            <label class="form-label fs-6">ຈຳນວນ: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mb-2" v-model="FormStore.amount" placeholder="....." />

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fs-6">ລາຄາຊື້: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-2" v-model="FormStore.price_buy"
                                        placeholder="....." />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-6">ລາຄາຂາຍ: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-2" v-model="FormStore.price_sell"
                                        placeholder="....." />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="table-responsive text-nowrap" v-if="!ShowForm">
                <div class=" d-flex justify-content-between mb-2">
                    <div class=" d-flex align-items-center">
                        <div class=" me-2 cursor-pointer" @click="ChangeSort()">
                            <i class='bx bx-sort-up fs-4' v-if="Sort == 'asc'"></i>
                            <i class='bx bx-sort-down fs-4' v-if="Sort == 'desc'"></i>
                        </div>
                        <select class=" form-select" v-model="PerPage" @change="GetStore()">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class=" d-flex">
                        <input type="text" class=" form-control me-2" v-model="Search" @keyup.enter="GetStore()"
                            placeholder="ຄົ້ນຫາ...">
                        <button type="button" class="btn btn-primary" @click="AddStore()"> <i
                                class='bx bxs-user-plus me-2 fs-4'></i>
                            ເພີ່ມໃໝ່</button>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="70">ລະຫັດ</th>
                            <th width="150" class=" text-center">ຮູບພາບ</th>
                            <th>ຊື່ສິນຄ້າ</th>
                            <th width="180" class=" text-center">ລາຄາຊື້</th>
                            <th width="180" class=" text-center">ລາຄາຂາຍ</th>
                            <th width="90" class=" text-center">ຈັດການ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="list in StoreData.data" :key="list.id">
                            <td>{{ list.id }}</td>
                            <td>

                            </td>
                            <td>
                                {{ list.name }}

                            </td>
                            <td> {{ list.price_buy }}</td>
                            <td> {{ list.price_sell }}</td>
                            <td class=" text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" @click="EditStore(list.id)"><i
                                                class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                                        <a class="dropdown-item" href="javascript:void(0);" @click="DeleteStore(list.id)"><i
                                                class="bx bx-trash me-1"></i>
                                            ລຶບ</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <Pagination :pagination="StoreData" :offset="4" @paginate="GetStore($event)" />

                <!-- <button @click="showAlert">Hello world</button> -->
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useStore } from '../store/auth';
export default {
    name: 'WorkspaceJsonStore',
    setup() {
        const store = useStore();
        return { store }
    },
    data() {
        return {
            ShowForm: false,
            FormType: true,
            EditID: '',
            Sort: 'asc',
            PerPage: '5',
            Search: '',
            StoreData: [],
            FormStore: {
                name: '',
                image: '',
                amount: '',
                price_buy: '',
                price_sell: '',

            }

        };
    },

    mounted() {

    },
    computed: {
        CheckForm() {
            if (this.FormStore.name == '' || this.FormStore.amount == '' || this.FormStore.price_buy == '' || this.FormStore.price_sell == '') {
                return true
            } else {
                return false
            }
        }
    },

    methods: {
        ChangeSort() {
            if (this.Sort == 'asc') {
                this.Sort = 'desc'
            } else {
                this.Sort = 'asc'
            }
            this.GetStore()
        },
        AddStore() {
            this.FormStore.name = ''
            this.FormStore.image = ''
            this.FormStore.amount = ''
            this.FormStore.price_buy = ''
            this.FormStore.price_sell = ''


            this.ShowForm = true;
            this.FormType = true;

        },
        CancelStore() {
            this.ShowForm = false;

        },
        EditStore(id) {
            this.FormType = false;
            this.EditID = id;

            axios.get(`api/store/edit/${id}`, { headers: { Authorization: 'Bearer ' + this.store.get_token } }).then((res) => {

                this.FormStore = res.data
                this.ShowForm = true

            }).catch((error) => {
                console.log(error);
            })
        },
        DeleteStore(id) {
            axios.delete(`api/store/delete/${id}`, { headers: { Authorization: 'Bearer ' + this.store.get_token } }).then((res) => {

                if (res.data.success) {
                    this.GetStore()


                } else {
                    // update

                }

            }).catch((error) => {
                console.log(error);
            })
        },
        SaveStore() {

            if (this.FormType) {
                // add

                axios.post('api/store/add', this.FormStore, { headers: { Authorization: 'Bearer ' + this.store.get_token } }).then((res) => {

                    console.log(res.data);
                    if (res.data.success) {
                        this.GetStore()
                        this.ShowForm = false

                    } else {
                        // update

                    }

                }).catch((error) => {
                    console.log(error);
                })

            } else {
                /// update
                axios.post(`api/store/update/${this.EditID}`, this.FormStore, { headers: { Authorization: 'Bearer ' + this.store.get_token } }).then((res) => {

                    console.log(res.data);
                    if (res.data.success) {
                        this.GetStore()
                        this.ShowForm = false

                    } else {


                    }

                }).catch((error) => {
                    console.log(error);
                })

            }

        },
        GetStore(page) {
            console.log('get')

            axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`, { headers: { Authorization: 'Bearer ' + this.store.get_token } }).then((res) => {
                {

                    this.StoreData = res.data

                }
            }).catch((error) => {
                console.log(error)

            })
        },

    },
    created() {
        this.GetStore();
    },
    watch: {
        Search() {
            if (this.Search == '') {
                this.GetStore()
            }

        }
    }



};
</script>

<style lang="scss" scoped></style>