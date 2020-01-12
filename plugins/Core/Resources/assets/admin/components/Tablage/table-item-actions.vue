<template>
    <td v-if="eloquent_status == 'active'" class="text-xs-right">
        <v-dialog
                v-model="dialog"
                width="500"
        >
            <v-card>
                <v-card-title
                        class="headline grey lighten-2"
                        primary-title
                >
                    Delete confirmation
                </v-card-title>

                <v-card-text>
                    Are you sure you want to delete? This action will be permanent.
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            color="primary"
                            flat
                            @click.native="() => {
                                dialog = false;
                                $events.$emit('table.delete-data', item.id)

                            }"
                    >
                        Accept
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <div style="display: inline-flex">
            <v-btn v-for="(action, index) in actions"
                   :key="index"
                   :color="action.color"
                   :dark="action.dark"
                   :title="$t(action.text)"
                   @click="(action.text !== 'table.delete') ? action.callback(item) : dialog = true"
                   :disabled="action.disabled && action.disabled(item) || action.text == 'table.block'  && role =='User' "
                   small
                   :fab="action.fab"
                   :loading="$store.state.fetching"
            >
            <span v-if="!action.fab">
                {{ $t(action.text) }}
            </span>
                <v-icon :right="!action.fab"
                        v-if="action.icon">
                    {{action.icon}}
                </v-icon>

            </v-btn>
        </div>
    </td>
    <td v-else>
        <v-btn small dark error outline @click.native="$events.$emit('table.force-delete-data', item.id)">
            {{$t('table.force-delete')}}
        </v-btn>
        <v-btn small dark default outline @click.native="$events.$emit('table.restore-data', item.id)">
            {{$t('table.restore')}}
        </v-btn>
    </td>
</template>

<script>

    import Component from "vue-class-component";
    import Vue from "vue";

    @Component({
        props: {
            route: {
                required: true,
                type: String
            },
            item: {
                type: Object,
                required: true
            },
            actions: {
                required: true,
                type: Array,
                default: () => [
                    {
                        text: 'table.edit',
                        color: 'primary',
                        dark: false,
                        callback: (item) => {
                            console.info(item)
                        },
                        disabled: (item) => {
                            return false;
                        }
                    }
                ],

            }
        }
    })
    export default class TableItemActions extends Vue {
        eloquent_status = 'active';
        dialog = false;
        action_cb = null;
        role = ""

        mounted(){
            this.role = this.$store.state.user.role.name
        }
    }
</script>