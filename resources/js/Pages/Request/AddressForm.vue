<template>
    <div class="bg-gray-300 flex flex-wrap rounded-md p-3">
        <div class="basis-full flex items-center justify-end">
            <button type="button" class="rounded-full bg-red-400 p-1 hover:bg-red-700 transition" @click="removeAddress(index)" v-show="enableDelete">
                <TrashIcon class="h-4 w-4 m-auto text-white"/>
            </button>
        </div>
         <div class="basis-1/3 px-3">
            <el-form-item label="Numbre de empresa o persona fisica" :prop="`addresses[${id}].name`"
            :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                <el-input v-model="value.name" placeholder="Numbre de empresa o persona fisica" id="name" name="name">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Ciudad" :prop="`addresses[${id}].city`"
            :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                <el-input v-model="value.city" placeholder="Ciudad" id="city" name="city">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Direccion" :prop="`addresses[${id}].address`"
            :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                <el-input v-model="value.address" placeholder="Direccion" id="address" name="address">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Telefono" :prop="`addresses[${id}].phone`"
            :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                <el-input v-model="value.phone" placeholder="Telefono" id="phone" name="phone">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Preguntas extendidas" :prop="`addresses[${id}].extended`">
                <el-checkbox v-model="value.hasExtendedQuestions" @change="toggleExtendedQuestions"></el-checkbox>
            </el-form-item>
        </div>
        <div class="basis-full px-3" >
            <el-form-item label="Notas" :prop="`addresses[${id}].notes`">
                <el-input type="textarea" v-model="value.notes" placeholder="Notas" id="notes" name="notes">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        

    </div>
</template>

<script>
import { SaveAsIcon, OfficeBuildingIcon, UserIcon, PlusIcon, InformationCircleIcon, TrashIcon, XIcon, ClipboardCheckIcon } from '@heroicons/vue/solid'
import {EXTENDED_QUESTIONS_PER_REQUEST} from '../../config'
import { showNotification } from '../../Utils/helpers';

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
    props: ['value', 'id', 'enableDelete'],
    data () {
        return {

        }
    },
    methods: {
        removeAddress () {
            this.$emit('removeAddress', this.id);
        },
        addExtendedQuestion () {
            if (this.totalExtendedQuestionsQnt >= EXTENDED_QUESTIONS_PER_REQUEST) {
                this.showMaxNotification()
                return
            }
            this.value.extendedQuestions.push({
                name: '',
                type: 'text',
            })
        },
        removeExtendedQuestion (index) {
            if (!this.canDeleteExtdQuestions) return
            this.value.extendedQuestions.splice(index, 1);
        },
        toggleExtendedQuestions (value) {
            if (this.totalExtendedQuestionsQnt >= EXTENDED_QUESTIONS_PER_REQUEST) {
                this.showMaxNotification()
                this.value.hasExtendedQuestions = false;
            }

            if (value && this.extendedQuestionsQnt <= 0) this.addExtendedQuestion()
        },
        showMaxNotification () {
            showNotification('error', 'Maximo alcanzado', `Se permiten maximo ${EXTENDED_QUESTIONS_PER_REQUEST} por solicitud.`)
        }
    },
    computed: {
        canDeleteExtdQuestions () {
            return this.value.extendedQuestions.length > 1
        },
        totalExtendedQuestionsQnt () {
            return this.$store.getters.extendedQuestionsQnt
        }, 
        extendedQuestionsQnt () {
            return this.value.extendedQuestions.length
        }, 
    }
}
</script>