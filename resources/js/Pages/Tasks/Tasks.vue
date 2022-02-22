<template>
    <app-layout>
        <Head>
            <title>Tareas</title>
        </Head>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span>Tareas</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


                <div class="flex items-center gap-2 mb-5">
                    <Link :href="route('tasks.create')">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <div class="flex justify-center items-center gap-2">
                                <span>Nuevo</span>
                                <PlusIcon class="h-5 w-5"/>
                            </div>
                        </button>
                    </Link>

                    <Search :action="route('tasks.index')"/>
                </div>


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="">
                        <!-- aber
                        <pre>
                            {{tasks.data}}
                        </pre> -->
                        <el-table :data="tasks.data" stripe class="w-full">
                            <el-table-column prop="name" label="Promotor">
                                <template #default="scope">
                                    <span>{{ scope.row.user.name }}</span>
                                </template>
                            </el-table-column>
                            <el-table-column prop="city" label="Ciudad"/>
                            <el-table-column prop="address" label="Direccion">
                                <template #default="scope">
                                    <span>{{ scope.row.request.addresses[0].address }}</span>
                                </template>
                            </el-table-column>
                            <el-table-column prop="status" label="Status"/>
                            <el-table-column prop="created_at" label="Fecha de creacion">
                                <template #default="scope">
                                    <span>{{ dayjs(scope.row.created_at).locale('es').format('YYYY/MM/DD') }}</span>
                                </template>
                            </el-table-column>
                            <el-table-column label="Operaciones">
                                <template #default="scope">
                                    <div class="flex items-center gap-3">
                                        <Link :href="route('request.evaluate', {id: scope.row.id})">
                                            <button size="small" class="bg-blue-400 text-white rounded-sm px-2 py-1 text-xs">Reasignar</button>
                                        </Link>
                                        <el-button size="small" type="danger" @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
                                    </div>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                    <div class="p-4">
                        <pagination class="mt-6" :links="tasks.links" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Pagination from '@/Components/Pagination'
    import { PlusIcon, SearchIcon } from '@heroicons/vue/solid'
    import Search from '../../Components/Search.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia'
    import 'dayjs/locale/es'
    import dayjs from 'dayjs'

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            Pagination,
            Search,
            Head,
            PlusIcon,
        },
        props: ['tasks', 'can'],
        data () {
            return {
                dayjs,
            }
        },
        mounted () {
        },
        methods: {
            handleDelete (index, row) {
                console.log(row)

                this.$confirm('¿Esta seguro de eliminar este elemento?').then(() => {
                    Inertia.delete( route('tasks.destroy', {id: row.id}) );
                })
            }
        }
    })
</script>
