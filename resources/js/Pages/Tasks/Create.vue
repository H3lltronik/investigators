<template>
    <app-layout>

        <Head>
            <title>
                <template v-if="entity">Editar</template>
                <template v-else>Crear</template>
                Financiera
            </title>
        </Head>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span v-if="entity">Editar</span>
                <span v-else>Crear</span>
                <span> Financiera</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" v-loading="loading">
                    <div class="px-4 py-7">
                        <!-- aber
                        <pre>
                            {{users}}
                        </pre> -->

                        <el-form ref="form" :rules="rules" :action="route('financials.store')" :model="form" label-position="top" >
                            <div class="flex flex-wrap">
                                <div class="basis-1/3 px-3">
                                    <el-form-item label="Nombre" prop="name">
                                        <el-input v-model="form.name" placeholder="Nombre" id="name" name="name">
                                            <template #prefix>
                                                <UserIcon class="h-4 w-4 m-auto"/>
                                            </template>
                                        </el-input>
                                    </el-form-item>
                                </div>
                                <div class="basis-1/3 px-3">
                                    <el-form-item label="Direccion" prop="address">
                                        <el-input v-model="form.address" placeholder="Direccion" id="address" name="address">
                                            <template #prefix>
                                                <ClipboardCheckIcon class="h-4 w-4 m-auto"/>
                                            </template>
                                        </el-input>
                                    </el-form-item>
                                </div>
                                <div class="basis-1/3 px-3">
                                    <el-form-item label="Banco" prop="bank">
                                        <el-input v-model="form.bank" placeholder="Banco" id="bank" name="name">
                                            <template #prefix>
                                                <OfficeBuildingIcon class="h-4 w-4 m-auto"/>
                                            </template>
                                        </el-input>
                                    </el-form-item>
                                </div>
                                <div class="basis-full px-3">
                                    <el-form-item label="Descripcion" prop="description">
                                        <el-input type="textarea" rows="10" v-model="form.description" placeholder="Descripcion" id="description" description="name">
                                            <template #prefix>
                                                <InformationCircleIcon class="h-4 w-4 m-auto"/>
                                            </template>
                                        </el-input>
                                    </el-form-item>
                                </div>

                                <div class="basis-full px-3">
                                    <hr class="my-3">

                                    <div class="">Asignar a usuario</div>

                                    <div class="">
                                        <el-form-item prop="user_id" class="mt-5" label="Usuario">
                                            <el-select v-model="form.user_id" id="user_id" name="user_id" class="m-2" placeholder="Usuario" size="large">
                                                <el-option v-for="user in users" :key="user.id" :label="user.name" :value="user.id"/>
                                            </el-select>
                                        </el-form-item>
                                    </div>
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
    import { SaveAsIcon, OfficeBuildingIcon, UserIcon, InformationCircleIcon, XIcon, ClipboardCheckIcon } from '@heroicons/vue/solid'
    import { financialsForm } from '../../Common/rules';

    export default defineComponent({
        components: {
            AppLayout,
            SaveAsIcon,
            OfficeBuildingIcon,
            XIcon,
            Link,
            UserIcon,
            InformationCircleIcon,
            ClipboardCheckIcon,
            Head,
        },
        props: ['entity', 'users', 'roles', 'can'],
        data () {
            return {
                form: {
                    roles: [],
                },
                rules: financialsForm,
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
                        
                        Inertia.post( route('financials.store'), this.form );
                        Inertia.on('finish', () => { this.loading = false })
                    }
                });
            }
        }
    })
</script>
