<template>
    <app-layout>
        <Head>
            <title>Usuarios</title>
        </Head>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span>Usuarios</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


                <div class="flex items-center gap-2 mb-5">
                    <Link :href="route('users.create')">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <div class="flex justify-center items-center gap-2">
                                <span>Nuevo</span>
                                <PlusIcon class="h-5 w-5"/>
                            </div>
                        </button>
                    </Link>

                    <Search :action="route('users.index')"/>
                </div>


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="">
                        <!-- <pre>
                            {{users.data}}
                        </pre> -->
                        <el-table :data="users.data" stripe class="w-full">
                            <el-table-column prop="name" label="Nombre" />
                            <el-table-column prop="email" label="Correo"/>
                            <el-table-column label="Operaciones">
                                <template #default="scope">
                                    <div class="flex items-center gap-3">
                                        <Link :href="route('users.show', {id: scope.row.id})">
                                            <el-button size="small">Edit</el-button>
                                        </Link>
                                        <el-button size="small" type="danger" @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
                                    </div>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                    <div class="p-4">
                        <pagination class="mt-6" :links="users.links" />
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
        props: ['users', 'can'],
        data () {
            return {
            }
        },
        mounted () {
        },
        methods: {
            handleDelete (index, row) {
                console.log(row)

                this.$confirm('¿Esta seguro de eliminar este elemento?').then(() => {
                    Inertia.delete( route('users.destroy', {id: row.id}) );
                })
            }
        }
    })
</script>
