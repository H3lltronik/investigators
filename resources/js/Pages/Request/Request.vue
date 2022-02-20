<template>
    <app-layout>
        <Head>
            <title>Solicitudes</title>
        </Head>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span>Solicitudes</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


                <div class="flex items-center gap-2 mb-5">
                    <Link :href="route('request.create')">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <div class="flex justify-center items-center gap-2">
                                <span>Nuevo</span>
                                <PlusIcon class="h-5 w-5"/>
                            </div>
                        </button>
                    </Link>

                    <Search :action="route('request.index')"/>
                </div>


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="">
                        <!-- aber
                        <pre>
                            {{requests.data}}
                        </pre> -->
                        <el-table :data="requests.data" stripe class="w-full" v-if="requests">
                            <el-table-column prop="name" label="Nombre" />
                            <el-table-column prop="address" label="Direccion"/>
                            <el-table-column prop="bank" label="Banco"/>
                            <el-table-column prop="description" label="Descripcion"/>
                            <el-table-column label="Operaciones">
                                <template #default="scope">
                                    <div class="flex items-center gap-3">
                                        <Link :href="route('request.show', {id: scope.row.id})">
                                            <el-button size="small">Edit</el-button>
                                        </Link>
                                        <el-button size="small" type="danger" @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
                                    </div>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                    <div class="p-4">
                        <pagination class="mt-6" :links="requests.links" />
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

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            Pagination,
            Search,
            Head,
            PlusIcon,
        },
        props: ['requests', 'can'],
        data () {
            return {
            }
        },
        mounted () {
        },
        methods: {
            handleDelete (index, row) {
                this.$confirm('¿Esta seguro de eliminar este elemento?').then(() => {
                    Inertia.delete( route('request.destroy', {id: row.id}) );
                })
            }
        }
    })
</script>
