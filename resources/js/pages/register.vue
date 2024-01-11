<template>
    <div class=" d-flex justify-content-center">
        <div class="authentication-wrapper authentication-basic container-p-y col-md-4">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <span class="app-brand-logo demo">

                            </span>


                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2 text-center">ລົງທະບຽນບັນຊີໃໝ່</h4>


                        <div class="mb-3">
                            <label for="user_name" class="form-label">ຊື່ຜູ້ໃຊ້:</label>
                            <input type="text" class="form-control" id="user_name" v-model="user_name" placeholder="....">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">ອີເມວລ໌:</label>
                            <input type="text" class="form-control" id="email" v-model="email" name="email-username"
                                placeholder="....">
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                            <div class="input-group input-group-merge">
                                <input :type="show_pass" id="password" class="form-control" v-model="password"
                                    name="password" placeholder="ກຳນົດລະຫັດ 6 ໂຕ" aria-describedby="password">

                                <span class="input-group-text cursor-pointer"
                                    @click="show_pass == 'password' ? show_pass = 'text' : show_pass = 'password'">
                                    <i class="bx bx-hide" v-if="show_pass == 'password'"></i>
                                    <i class='bx bx-show' v-if="show_pass == 'text'"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">ຍືນຍັນ ລະຫັດຜ່ານ:</label>
                            <div class="input-group input-group-merge">
                                <input :type="show_pass" id="password" class="form-control" v-model="password2"
                                    name="password" placeholder="ກຳນົດລະຫັດ 6 ໂຕ" aria-describedby="password">
                                <span class="input-group-text cursor-pointer"
                                    @click="show_pass == 'password' ? show_pass = 'text' : show_pass = 'password'">
                                    <i class="bx bx-hide" v-if="show_pass == 'password'"></i>
                                    <i class='bx bx-show' v-if="show_pass == 'text'"></i>
                                </span>
                            </div>
                        </div>
                        <div class="alert alert-warning" role="alert" v-if="text_error">
                            {{ text_error }}
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit" :disabled="check_bt"
                                @click="Register()">ລົງທະບຽນ</button>
                        </div>


                        <p class="text-center">
                            <span>ມີບັນຊີແລ້ວ!</span>
                            <router-link to="/login">
                                <span>ເຂົ້າສູ່ລະບົບ</span>
                            </router-link>
                        </p>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'WorkspaceJsonRegister',

    data() {
        return {
            user_name: '',
            email: '',
            password: '',
            password2: '',
            text_error: '',
            show_pass: 'password'

        };
    },

    mounted() {

    },
    computed: {
        check_bt() {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // ກວດ ອີເມວລ໌
            if (this.email) {
                if (!emailRegex.test(this.email)) {
                    this.check_email = 'ອີເມວລ໌ບໍ່ຖຶກຕ້ອງ!'
                } else {
                    this.check_email = ''
                }
            }

            // ກວດລະຫັດຜ່ານ
            if (this.password) {
                if (this.password.length < 6) {
                    this.check_pass = 'ລະຫັດຜ່ານຕ້ອງຫຼາຍກ່ວາ 6 ຕົວອັກສອນ!'
                } else {
                    this.check_pass = ''
                }
            }

            // ທຳການປິດປຸ່ມ ຖ້າຂໍ້ມູນບໍ່ຖຶກຕ້ອງ
            if (!emailRegex.test(this.email) || this.password.length < 6) {
                return true;
            } else {
                return false;
            }
        }
    },

    methods: {
        Register() {
            if (this.user_name == '' || this.email == '' || this.password == '' || this.password2 == '') {
                this.text_error = 'ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ'
            } else {

                if (this.password == this.password2) {
                    this.text_error = ''

                    axios.post('api/register', {
                        from_user_name: this.user_name,
                        from_email: this.email,
                        from_password: this.password
                    }).then((res) => {

                        console.log(res)

                        if (res.data.success) {
                            this.text_error = ''
                            this.user_name = ''
                            this.email = ''
                            this.password = ''
                            this.password2 = ''
                            /// ໄປໜ້າ login
                            this.$router.push('/login')
                        } else {
                            this.text_error = res.data.message
                        }

                    }).catch((error) => {
                        console.log(error)
                    })

                } else {
                    this.text_error = 'ລະຫັດຜ່ານບໍ່ກົງກັນ!'
                }
            }
        }
    },
};
</script>

<style lang="scss" scoped></style>