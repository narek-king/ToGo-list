<template>

    <span class="table-entries-info">
        {{ chunkInfo }}
        <span v-if="body.filters">
            {{ fromInfo }}
        </span>
    </span>

</template>

<script>

export default {
    name: 'RecordsInfo',

//    data(){
//        return {
//            chunkInfo: '',
//            fromInfo: ''
//        }
//    },

    props: {
        start: {
            type: Number,
            required: true,
        },
        body: {
            type: Object,
            required: true,
        },
        i18n: {
            type: Function,
            required: true,
        },
    },

    computed: {
        hasRecords() {
            return this.body.data.length > 0;
        },
        startInfo() {
            return this.hasRecords
                ? this.start + 1
                : 0;
        },
        filteredInfo() {
            return this.body.filters
                ? `of ${this.body.fullRecordInfo ? this.body.filtered : '...'} \
                 entries`
                : `of ${this.body.count} entries`;
        },
        chunkInfo() {
            return this.hasRecords
                ? `From ${this.startInfo} to \
                ${this.start + this.body.data.length} \
                ${this.filteredInfo}`
                : 'No records were found';
        },
        fromInfo() {
            return `(filtered from ${this.body.count} total records)`;
        },
    },
};

</script>

<style>

    .table-entries-info {
        font-size: 15px;
    }

</style>
