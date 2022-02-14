<template>
    <el-form :inline="true" class="h-[32px]" :action="action">
        <el-form-item style="margin: 0;">
            <el-input v-model="search" placeholder="Buscar registro" id="search" name="search" :clearable="clearable">
                <template #prefix>
                    <SearchIcon class="h-4 w-4 m-auto"/>
                </template>
            </el-input>
        </el-form-item>
    </el-form>
</template>

<script>
import { SearchIcon } from '@heroicons/vue/solid';

export default {
    props: {
        action: {
            type: String,
            required: true,
        },
        clearable: {
            type: Boolean,
            required: false,
            default: false,
        },
    },
    components: {
        SearchIcon,
    },
    data () {
        return {
            search: '',
        }
    },
    mounted () {
        const url = new URL( window.location );
        this.search = url.searchParams.get('search');
    }
}
</script>