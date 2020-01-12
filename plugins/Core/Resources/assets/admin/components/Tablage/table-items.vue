<template>
    <tr>
        <td v-if="bulkActions" :active="props.selected" @click="props.selected = !props.selected">
            <v-checkbox
                    primary
                    hide-details
                    :input-value="props.selected"
            ></v-checkbox>
        </td>
        <td v-for="header in headers"
            v-if="header.value !== 'actions'"
            :class="{'text-xs-right': header.align === 'right' || !header.align}"
            >
            <table-item :item="props.item" :header="header"></table-item>
        </td>

        <table-item-actions :route="route" :item="props.item" :headers="headers" :actions="actions"></table-item-actions>
    </tr>
</template>

<script>

    import Component from "vue-class-component";
    import TableItemActions from './table-item-actions';
    import TableItem from './table-item';
    import Vue from "vue";

    @Component({
        props: ['props', 'headers', 'route', 'actions', 'bulkActions'],
        components: {
            TableItemActions,
            TableItem
        }
    })
    export default class TableItems extends Vue {

    }
</script>
