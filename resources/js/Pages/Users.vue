<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)">Edit</el-button>
                                    <el-button size="small" type="danger" @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
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

    export default defineComponent({
        components: {
            AppLayout,
            Pagination,
        },
        props: ['users', 'can']
    })
</script>
