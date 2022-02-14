<template>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <div class="flex justify-center items-center gap-2">
            <slot></slot>
            <SaveAsIcon class="h-5 w-5"/>
        </div>
    </button>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true,
        },
        icon: {
            type: Object,
            required: false,
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