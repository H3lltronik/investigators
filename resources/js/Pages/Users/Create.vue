<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span v-if="entity">Editar</span>
                <span v-else>Crear</span>
                <span> Usuario</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" v-loading="loading">
                    <div class="px-4 py-7">

                        <el-form ref="form" :rules="rules" :action="route('users.store')" :model="form" label-position="top" >
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
                                    <el-form-item label="Telefono Celular" prop="phone">
                                        <el-input v-model="form.phone" placeholder="Telefono Celular" id="phone" name="phone">
                                            <template #prefix>
                                                <PhoneIcon class="h-4 w-4 m-auto"/>
                                            </template>
                                        </el-input>
                                    </el-form-item>
                                </div>
                                <div class="basis-1/3 px-3">
                                    <el-form-item label="Domicilio" prop="address">
                                        <el-input v-model="form.address" placeholder="Domicilio" id="address" name="address">
                                            <template #prefix>
                                                <MailIcon class="h-4 w-4 m-auto"/>
                                            </template>
                                        </el-input>
                                    </el-form-item>
                                </div>
                                <div class="basis-1/3 px-3">
                                    <el-form-item label="Email" prop="email">
                                        <el-input v-model="form.email" placeholder="Email" id="email" name="email">
                                            <template #prefix>
                                                <MailIcon class="h-4 w-4 m-auto"/>
                                            </template>
                                        </el-input>
                                    </el-form-item>
                                </div>
                                <div class="basis-1/3 px-3">
                                    <el-form-item label="Contraseña" prop="password">
                                        <el-input type="password" v-model="form.password" placeholder="Contraseña" id="password" name="password">
                                            <template #prefix>
                                                <LockClosedIcon class="h-4 w-4 m-auto"/>
                                            </template>
                                        </el-input>
                                    </el-form-item>
                                </div>

                                <div class="basis-full px-3">
                                    <hr class="my-3">

                                    <div class="">Roles de la cuenta</div>

                                    <el-form-item prop="userRoles" class="mt-5">
                                        <el-checkbox-group v-model="form.userRoles" class="flex flex-col">
                                            <el-checkbox :label="role.name" v-for="(role, index) in roles" :key="index"></el-checkbox>
                                        </el-checkbox-group>
                                    </el-form-item>
                                </div>
                            </div>
                        </el-form>

                        <div class="flex justify-end items-center gap-5 mt-5">
                            <Link :href="route('users.index')">
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
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
    import { SaveAsIcon, PhoneIcon, UserIcon, MailIcon, LockClosedIcon, XIcon } from '@heroicons/vue/solid'
    import { userForm } from '../../Common/rules';

    export default defineComponent({
        components: {
            AppLayout,
            SaveAsIcon,
            PhoneIcon,
            XIcon,
            Link,
            MailIcon,
            LockClosedIcon,
            UserIcon,
        },
        props: ['entity', 'roles', 'can'],
        data () {
            return {
                form: {
                    roles: [],
                },
                rules: userForm,
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
                        
                        Inertia.post( route('users.store'), this.form );
                    }
                });
            }
        }
    })
</script>
