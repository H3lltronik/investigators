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
                            {{financials}}
                        </pre> -->

                        <el-form ref="form" :rules="rules" :action="route('financials.store')" :model="form" label-position="top" >
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
                                    <AddressForm :value="address" :id="index" @removeAddress="removeAddress"/>
                                </div>
                            </div>
                            
                        </el-form>

                        <div class="flex justify-end items-center gap-5 mt-5">
                            <Link :href="route('financials.index')">
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    <div class="flex justify-center items-center gap-2">
                                        <span>Cancelar</span>
                                        <XIcon class="h-5 w-5"/>
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
    import { requestsForm } from '../../Common/rules';
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
                form: {
                    addresses: [{
                        name: '',
                        city: '',
                        address: '',
                        phone: '',
                        notes: '',
                    }],
                },
                rules: requestsForm,
                loading: false,
            }
        },
        created () {
            if (this.entity) {
                this.form = this.entity;
            }
        },
        methods: {
            submitForm () {
                this.$refs['form'].validate(async (isValid) => {
                    if (isValid) {
                        this.loading = true;
                        
                        Inertia.post( route('requests.store'), this.form );
                    }
                });
            },
            addAddress () {
                this.form.addresses.push({});
            },
            removeAddress (index) {
                this.form.addresses.splice(index, 1);
            },
        }
    })
</script>
