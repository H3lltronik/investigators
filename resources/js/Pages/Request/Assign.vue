<template>
    <app-layout>

        <Head>
            <title>
                Evaluar solicitud
            </title>
        </Head>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Evaluar solicitud
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" v-loading="loading">
                    <div class="px-4 py-7">
                        <!-- <pre>
                            {{task}}
                        </pre> -->

                        <el-form ref="requestInfo" :model="requestInfo" label-position="top" >
                            <div class="mb-5 flex align-center gap-5 p-1 pb-3 shadow-md">
                                <div class="basis-1/2 flex flex-col align-center">
                                    <div class="mb-4 ml-2 text-lg"><strong>Financiera</strong></div>

                                    <div class="pl-3">
                                        <div class="">
                                            <strong>Nombre: </strong>
                                            <span>{{requestInfo.financial.name}}</span>
                                        </div>
                                        <div class="">
                                            <strong>Banco: </strong>
                                            <span>{{requestInfo.financial.bank}}</span>
                                        </div>
                                        <div class="">
                                            <strong>Descripcion: </strong>
                                            <span>{{requestInfo.financial.description}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="basis-1/2 flex flex-col align-center">
                                    <div class="mb-4 ml-2 text-lg"><strong>Cliente</strong></div>

                                    <div class="pl-3">
                                        <div class="">
                                            <strong>Nombre: </strong>
                                            <span>{{requestInfo.financial.user.name}}</span>
                                        </div>
                                        <div class="">
                                            <strong>Telefono: </strong>
                                            <span>{{requestInfo.financial.user.phone}}</span>
                                        </div>
                                        <div class="">
                                            <strong>Direccion: </strong>
                                            <span>{{requestInfo.financial.user.address}}</span>
                                        </div>
                                        <div class="">
                                            <strong>Email: </strong>
                                            <span>{{requestInfo.financial.user.email}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex align-center justify-between">
                                <div class="mb-4 ml-2">Domicilios ligados</div>
                            </div>
                            
                            <div class="flex flex-col gap-5">
                                <div class="" v-for="(address, index) in requestInfo.addresses" :key="index">
                                    <AddressForm :editable="false" :value="address" :id="index" @removeAddress="removeAddress" :enableDelete="canDeleteAddress"/>
                                </div>
                            </div>
                            
                        </el-form>

                        <div class="mt-4">
                            <div class="flex align-center justify-between">
                                <div class="mb-4 ml-2">Asignar solicitud a promotor</div>
                            </div>

                            <el-form ref="form" :model="form" label-position="top" >
                                <el-form-item label="Promotor" prop="promoter_id"
                                :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                                    <el-select v-model="form.promoter_id" placeholder="Promotor" filterable>
                                        <el-option v-for="promoter in promoters" :key="promoter.id" :label="promoter.name" :value="promoter.id">{{ promoter.name }}</el-option>
                                    </el-select>
                                </el-form-item>

                                <el-form-item prop="request_id" hidden style="display: none !important;">
                                    <el-input type="text" disabled hidden v-model="form.request_id"/>
                                </el-form-item>

                                <el-form-item prop="task_id" hidden style="display: none !important;">
                                    <el-input type="text" disabled hidden v-model="form.task_id"/>
                                </el-form-item>
                            </el-form>
                        </div>

                        

                        <div class="flex justify-end items-center gap-5 mt-5">
                            <Link :href="route('request.index')">
                                <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                    <div class="flex justify-center items-center gap-2">
                                        <span>Cancelar</span>
                                        <XIcon class="h-5 w-5"/>
                                    </div>
                                </button>
                            </Link>
                            <Link :href="route('request.index')">
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    <div class="flex justify-center items-center gap-2">
                                        <span>Rechazar</span>
                                        <TrashIcon class="h-5 w-5"/>
                                    </div>
                                </button>
                            </Link>
                            <button v-on:click="submitForm" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <div class="flex justify-center items-center gap-2">
                                    <span>Guardar</span>
                                    <SaveAsIcon class="h-5 w-5"/>
                                </div>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { SaveAsIcon, OfficeBuildingIcon, UserIcon, PlusIcon, InformationCircleIcon, TrashIcon, XIcon, ClipboardCheckIcon } from '@heroicons/vue/solid'
    import AddressForm from './AddressForm.vue';

    export default defineComponent({
        components: {
            AppLayout,
            SaveAsIcon,
            OfficeBuildingIcon,
            XIcon,
            PlusIcon,
            Link,
            UserIcon,
            TrashIcon,
            InformationCircleIcon,
            ClipboardCheckIcon,
            Head,
            AddressForm
        },
        props: ['entity', 'financials', 'promoters', 'can', 'task'],
        data () {
            return {
                loading: false,
                form: {},
            }
        },
        created () {
            if (this.entity) {
                this.requestInfo = this.entity;
                this.form.request_id = this.requestInfo.id;
            }
            if (this.task) {
                this.form.promoter_id = this.task.user_id
                this.form.task_id = this.task.id
            }
        },
        methods: {
            submitForm () {
                this.$refs['form'].validate(async (isValid) => {
                    if (isValid) {
                        this.loading = true;
                        
                        Inertia.post( route('request.assign'), this.form );
                        Inertia.on('finish', () => { this.loading = false })
                    }
                });
            },
            addAddress () {
                this.requestInfo.addresses.push({
                    name: '',
                    city: '',
                    address: '',
                    phone: '',
                    hasExtendedQuestions: false,
                    extended_questions: [
                        {
                            type: '',
                            name: '',
                        },
                    ]
                });
            },
            removeAddress (index) {
                if (!this.canDeleteAddress) return
                this.requestInfo.addresses.splice(index, 1);
            },
            
        },
        computed: {
            requestInfo: {
                get () {
                    return this.$store.getters.requestForm
                },
                set (value) {
                    this.$store.commit('updateRequestForm', value)
                }
            },
            canDeleteAddress () {
                return (this.requestInfo.addresses.length > 1)
            }, 
        },
    })
</script>
