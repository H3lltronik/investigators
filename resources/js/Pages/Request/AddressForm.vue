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
                <el-input :disabled="!editable" v-model="value.name" placeholder="Numbre de empresa o persona fisica" id="name" name="name">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Ciudad" :prop="`addresses[${id}].city`"
            :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                <el-input :disabled="!editable" v-model="value.city" placeholder="Ciudad" id="city" name="city">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Direccion" :prop="`addresses[${id}].address`"
            :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                <el-input :disabled="!editable" v-model="value.address" placeholder="Direccion" id="address" name="address">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Telefono" :prop="`addresses[${id}].phone`"
            :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                <el-input :disabled="!editable" v-model="value.phone" placeholder="Telefono" id="phone" name="phone">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-1/3 px-3">
            <el-form-item label="Preguntas extendidas" :prop="`addresses[${id}].extended`">
                <el-checkbox :disabled="!editable" v-model="value.hasExtendedQuestions" @change="toggleExtendedQuestions"></el-checkbox>
            </el-form-item>
        </div>
        <div class="basis-full px-3" >
            <el-form-item label="Notas" :prop="`addresses[${id}].notes`">
                <el-input type="textarea" :disabled="!editable" v-model="value.notes" placeholder="Notas" id="notes" name="notes">
                    <template #prefix>
                        <UserIcon class="h-4 w-4 m-auto"/>
                    </template>
                </el-input>
            </el-form-item>
        </div>
        <div class="basis-full px-3 pt-3 mt-1 border-t" v-show="value.hasExtendedQuestions">
            <div class="mb-3 flex items-center justify-between">
                <span>Preguntas extendidas</span>

                <button type="button" class="rounded-full bg-blue-400 p-1 hover:bg-blue-700 transition" @click="addExtendedQuestion"
                v-show="editable">
                    <PlusIcon class="h-4 w-4 m-auto text-white"/>
                </button>
            </div>
            <div class="flex items-center gap-5" v-for="(extendedQuestion, index) in value.extended_questions" :key="index">
                <el-form-item label="Tipo de pregunta" :prop="`addresses[${id}].extended_questions[${index}].type`" class=""
                :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                    <el-radio-group :disabled="!editable" v-model="extendedQuestion.type">
                        <el-radio label="text">Texto</el-radio>
                        <el-radio label="picture">Fotografia</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="Nombre de pregunta" :prop="`addresses[${id}].extended_questions[${index}].name`" class="basis-1/3"
                :rules="{required: true, message: 'Este campo es requerido', trigger: 'blur'}">
                    <el-input :disabled="!editable" v-model="extendedQuestion.name" placeholder="Nombre de pregunta">
                        <template #prefix>
                            <UserIcon class="h-4 w-4 m-auto"/>
                        </template>
                    </el-input>
                </el-form-item>

                <button type="button" class="rounded-full bg-red-700 p-1 hover:bg-red-400 transition" @click="removeExtendedQuestion(index)" 
                v-show="canDeleteExtdQuestions && editable">
                    <TrashIcon class="h-4 w-4 m-auto text-white"/>
                </button>
            </div>
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
    props: ['value', 'id', 'enableDelete', 'editable'],
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
            this.value.extended_questions.push({
                name: '',
                type: 'text',
            })
        },
        removeExtendedQuestion (index) {
            if (!this.canDeleteExtdQuestions) return
            this.value.extended_questions.splice(index, 1);
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
            return this.value.extended_questions.length > 1
        },
        totalExtendedQuestionsQnt () {
            return this.$store.getters.extendedQuestionsQnt
        }, 
        extendedQuestionsQnt () {
            return this.value.extended_questions.length
        }, 
    }
}
</script>