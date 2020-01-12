<template>
    <v-edit-dialog
            v-if="header.editable"
            lazy
            @save="update(item)"
            @cancel="cancel()"
    ><span v-html="getValue(item, header)"></span>
        <v-text-field
                v-if="getValue(item, header) || getValue(item, header) === ''"
                :readonly="header.value === 'id'"
                slot="input"
                label="Edit"
                v-model="item[header.value]"
                single-line
                counter
                :rules="messages.validation[header.value]"
        ></v-text-field>
    </v-edit-dialog>
    <div v-else v-html="getValue(item, header)">

    </div>
</template>

<script>

    import Vue from "vue";
    import Component from "vue-class-component";
    import {mapState} from 'vuex'

    @Component({
        props: ['header', 'item'],
        computed: {
            ...mapState(['messages'])
        }
    })
    export default class TableItem extends Vue {
        /*
         * Get Item Value
         */
        getValue(data, header) {
            if (header.callback) {
                return header.callback(data)
            }
            if (String(header.value).includes('.')) {
                let $val = header.value.split('.');
                if (data[$val[0]]) {
                    if ($val[2]) {
                        return data[$val[0]][$val[1]][$val[2]]
                    }
                    return data[$val[0]][$val[1]]
                }
            }

            if (String(header.value).includes('->')) {
                let $val = header.value.split('->');
                if (data[$val[0]]) {
                    if ($val[2]) {
                        return data[$val[0]][$val[1]][$val[2]]
                    }
                    return data[$val[0]][$val[1]]
                }
            }

            return data[header.value]
        }

        update(item) {
            this.$events.$emit('table.update-data', item);
        }

        cancel() {
            this.$events.$emit('table.reload-data');
        }
    }
</script>
