import Vue from 'vue';
import queryString from 'qs';
import {localStorageGetItem} from "../../plugins/local";

export default class DataTables extends Vue {
    api_url = '';
    search = '';
    totalItems = 0;
    items = [];
    loading = true;
    selected = [];
    pagination = {rowsPerPage: 10};
    eloquent = ['active', 'trashed'];

    eloquent_status = 'active';

    initTablage(name) {
        this.api_url = name;

        this.setWatchers();
        this.addEventListeners();


        this.getDataFromApi(true);

        if (Zexus.configs.echo.enabled) {
            this.addSocketListeners(name);
        }
    }

    addSocketListeners(name) {
        this.$echo.channel(`dashboard/tables/${name}`)
            .listen('.add', event => {
                this.$events.$emit('notify', {
                    type: 'success',
                    title: 'Success !',
                    message: 'New Data Been Added'
                });
                this.getDataFromApi();
            })
            .listen('.edit', event => {
                this.$events.$emit('notify', {
                    type: 'success',
                    title: 'Success !',
                    message: 'New Data Been Edited'
                });
                this.getDataFromApi();
            })
            .listen('.delete', event => {
                this.$events.$emit('notify', {
                    type: 'success',
                    title: 'Success !',
                    message: 'New Data Been Delete'
                });
                this.getDataFromApi();
            })
    }

    get query() {
        let columns = [];
        let index_sort = 0;
        let i = 0;
        this.headers.map(header => {
            columns.push({
                searchable: !!header.searchable,
                orderable: !!header.sortable,
                data: header.value,
                name: header.value
            });
            if (header.value === this.pagination.sortBy) index_sort = i;
            i++;
        });

        let order = [
            {
                column: index_sort,
                dir: (this.pagination.descending) ? 'desc' : 'asc'
            }
        ];
        return {
            draw: this.pagination.page,
            start: ((this.pagination.rowsPerPage * this.pagination.page) - this.pagination.rowsPerPage),
            length: this.pagination.rowsPerPage,
            search: {
                value: this.search,
                regex: false
            },
            columns,
            order
        }
    }

    setWatchers() {
        this.$watch('pagination', () => {
            if(!this.loading) {
                this.getDataFromApi();
            }
        }, {deep: true});

        this.$watch('search', () => {
            if(!this.loading) {
                this.getDataFromApi();
            }
        }, {deep: true});

        this.$watch('eloquent_status', () => this.getDataFromApi(), {deep: true});

        /*
         * On user updated columns
         * updated the current table columns
         */
        this.$events.$on('table.update-headers', columns => this.headers = columns);
    }


    getDataFromApi(first_load) {
        this.loading = true;
        this.$http.defaults.headers.common.Authorization = `Bearer ${localStorageGetItem('token')}`;
        let query = this.getSearchQuery(first_load);

        this.$http.get(this.api_url + '?' + query)
            .then(res => {
                this.items = res.data.data;
                this.totalItems = res.data.recordsTotal;
                this.loading = false;
                this.$forceUpdate()
            })

    }

    /**
     * Get Search Query
     * @param first_load
     * @returns query
     */
    getSearchQuery(first_load) {
        let query = this.query;
        if (first_load && this.$route.query.table) {
            let url_query = JSON.parse(this.$route.query.table);

            this.search = url_query.search.value;
            this.pagination = url_query.pagination;
            query = {
                ...query,
                order: url_query.order,
                search: url_query.search,
                columns: url_query.columns,
                draw: url_query.pagination.page,
                start: ((url_query.pagination.rowsPerPage * url_query.pagination.page) - url_query.pagination.rowsPerPage),
                length: url_query.pagination.rowsPerPage,
            };

        } else {
            this.$router.push({
                query: {
                    table: JSON.stringify({
                        search: this.query.search,
                        order: this.query.order,
                        columns: this.query.columns,
                        pagination: this.pagination
                    })
                }
            });
        }

        query = queryString.stringify(query);
        return query;
    }

    serialize(obj) {
        return '?' + queryString.stringify(obj)
    }

    /*
     * Soft Delete Helpers
     */
    deleteData(id) {
        this.$http.delete(`${this.api_url}/${id}?action=delete`)
            .then(res => {
                this.$events.$emit('notify', {
                    type: 'warning',
                    title: 'Warning !',
                    message: 'Data Was Removed Successfully!' // @TODO: add trans
                });
                this.getDataFromApi();
            });
    }

    restoreData(id) {
        this.$http.delete(`${this.api_url}/${id}?action=restore`)
            .then(res => {
                this.$events.$emit('notify', {
                    type: 'success',
                    title: 'Success !',
                    message: 'Data Was Restored Successfully!' // @TODO: add trans
                });
                this.getDataFromApi();
            });
    }

    forceDeleteData(id) {
        this.$http.delete(`${this.api_url}/${id}?action=force-delete`)
            .then(res => {
                this.$events.$emit('notify', {
                    type: 'error',
                    title: 'Success !',
                    message: 'Data Was Permanently Removed!' // @TODO: add trans
                });
                this.getDataFromApi();
            });
    }

    updateData(item) {
        this.$http.put(`${this.api_url}/${item.id}`, item)
            .then(res => {
                this.$events.$emit('notify', {
                    type: 'success',
                    title: 'Success !',
                    message: 'Data Was Updated Successfully!' // @TODO: add trans
                });
            });
    }


    isObject(val) {
        return val instanceof Object;
    }

    addEventListeners() {
        // Remove Old Events
        // this.$events.$off('table.reload-data');
        this.$events.$off('table.delete-data');
        this.$events.$off('table.update-data');
        this.$events.$off('table.force-delete-data');
        this.$events.$off('table.restore-data');

        // add New Events
        this.$events.$on('table.reload-data', () => this.getDataFromApi());
        this.$events.$on('table.delete-data', id => this.deleteData(id));
        this.$events.$on('table.update-data', item => this.updateData(item));
        this.$events.$on('table.force-delete-data', id => this.forceDeleteData(id));
        this.$events.$on('table.restore-data', id => this.restoreData(id));
    }

}