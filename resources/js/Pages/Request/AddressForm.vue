<template>
    <div class="bg-gray-300 flex flex-wrap rounded-md p-3">
        <div class="basis-full flex items-center justify-end">
            <button type="button" class="rounded-full bg-red-400 p-1 hover:bg-red-700 transition" @click="removeAddress(index)">
                <TrashIcon class="h-4 w-4 m-auto text-white"/>
            </button>
        </div>
         <div class="basis-1/3 px-3">
            <el-form-item label="Numbre de empresa o persona fisica" prop="name">
                <el-input v-model="value.name" placeholder="Numbre de empresa o persona fisica" id="name" name="name">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Ciudad" prop="name">
                <el-input v-model="value.city" placeholder="Ciudad" id="city" name="city">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Direccion" prop="name">
                <el-input v-model="value.address" placeholder="Direccion" id="address" name="address">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Telefono" prop="name">
                <el-input v-model="value.phone" placeholder="Telefono" id="phone" name="phone">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Preguntas extendidas" prop="extended">
                <el-checkbox v-model="value.isExtended"></el-checkbox>
            </el-form-item>
        </div>
        <div class="basis-full px-3">
            <el-form-item label="Notas" prop="name">
                <el-input type="textarea" v-model="value.notes" placeholder="Notas" id="notes" name="notes">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-full px-3 pt-3 mt-1 border-t">
            <div class="mb-3 flex items-center justify-between">
                <span>Preguntas extendidas</span>

                <button type="button" class="rounded-full bg-blue-400 p-1 hover:bg-blue-700 transition" @click="addExtendedQuestion">
                    <PlusIcon class="h-4 w-4 m-auto text-white"/>
                </button>
            </div>
            <div class="flex items-center gap-5">
                <el-form-item label="Tipo de pregunta" prop="name" class="">
                    <el-radio-group v-model="value.type">
                        <el-radio label="text">Texto</el-radio>
                        <el-radio label="picture">Fotografia</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="Nombre de pregunta" prop="name" class="basis-1/3">
                    <el-input v-model="value.notes" placeholder="Nombre de pregunta" id="name" name="name">
                        <template #prefix>
                            <UserIcon class="h-4 w-4 m-auto"/>
                        </template>
                    </el-input>
                </el-form-item>

                <button type="button" class="rounded-full bg-red-400 p-1 hover:bg-red-700 transition" @click="removeExtendedQuestion(index)">
                    <TrashIcon class="h-4 w-4 m-auto text-white"/>
                </button>
            </div>
        </div>

    </div>
</template>

<script>
import { SaveAsIcon, OfficeBuildingIcon, UserIcon, PlusIcon, InformationCircleIcon, TrashIcon, XIcon, ClipboardCheckIcon } from '@heroicons/vue/solid'

export default {
    components: {
        SaveAsIcon,
        OfficeBuildingIcon,
        XIcon,
        PlusIcon,
        UserIcon,
        TrashIcon,
        InformationCircleIcon,
        ClipboardCheckIcon,
    },
    props: ['value', 'id'],
    data () {
        return {

        }
    },
    methods: {
        removeAddress () {
            this.$emit('removeAddress', this.id);
        },
        addExtendedQuestion () {
            
        },
        removeExtendedQuestion () {
            
        },
    }
}
</script>