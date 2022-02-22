<template>
    <app-layout>

        <Head>
            <title>
                Formulario Solicitudes
            </title>
        </Head>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span v-if="entity">Editar</span>
                <span v-else>Crear</span>
                <span> Solicitud</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" v-loading="loading">
                    <div class="px-4 py-7">
                        <!-- aber
                        <pre>
                            {{$page.props.errors}}
                        </pre>-->
                        <!-- <pre>
                            {{form}}
                        </pre>  -->

                        <el-form ref="form" :action="route('request.store')" :model="form" label-position="top" >
                            <div class="flex flex-col align-center justify-between mb-4">
                                <div class="mb-4 ml-2">Financiera</div>

                                <el-form-item label="Financiera" prop="financial_id"
                                :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                                    <el-select v-model="form.financial_id" placeholder="Financiera" filterable>
                                        <el-option v-for="financial in financials" :key="financial.id" :label="financial.name" :value="financial.id">{{ financial.name }}</el-option>
                                    </el-select>
                                </el-form-item>
                            </div>

                            <div class="flex align-center justify-between">
                                <div class="mb-4 ml-2">Domicilios ligados</div>

                                <button type="button" v-on:click="addAddress" class="bg-blue-700 hover:bg-blue-200 text-white font-bold py-2 px-4 rounded h-8">
                                    <div class="flex justify-center items-center gap-2 text-sm">
                                        <span>Agregar</span>
                                        <PlusIcon class="h-[15px] w-[15px]"/>
                                    </div>
                                </button>
                            </div>
                            
                            <div class="flex flex-col gap-5">
                                <div class="" v-for="(address, index) in form.addresses" :key="index">
                                    <AddressForm :value="address" :id="index" @removeAddress="removeAddress" :enableDelete="canDeleteAddress"/>
                                </div>
                            </div>
                            
                        </el-form>

                        <div class="flex justify-end items-center gap-5 mt-5">
                            <Link :href="route('request.index')">
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    <div class="flex justify-center items-center gap-2">
                                        <span>Cancelar</span>
                                        <XIcon class="h-5 w-5"/>
                                    </div>
                                </button>
                            </Link>
                            <button v-on:click="submitForm" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <div class="flex justify-center items-center gap-2">
                                    <span>Solicitar</span>
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
        props: ['entity', 'financials', 'can'],
        data () {
            return {
                loading: false,
            }
        },
        created () {
            if (this.entity) {
                this.form = this.entity;
                this.form.addresses = this.form.addresses.map(address => {
                    return {
                        ...address,
                        hasExtendedQuestions: !!address.hasExtendedQuestions
                    }
                })
            }
        },
        methods: {
            submitForm () {
                this.$refs['form'].validate(async (isValid) => {
                    if (isValid) {
                        this.loading = true;
                        
                        Inertia.post( route('request.store'), this.form );
                        Inertia.on('finish', () => { this.loading = false })
                    }
                });
            },
            addAddress () {
                this.form.addresses.push({
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
                this.form.addresses.splice(index, 1);
            },
            
        },
        computed: {
            form: {
                get () {
                    return this.$store.getters.requestForm
                },
                set (value) {
                    this.$store.commit('updateRequestForm', value)
                }
            },
            canDeleteAddress () {
                return (this.form.addresses.length > 1)
            }, 
        },
    })
</script>
