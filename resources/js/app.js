import BootstrapVue from 'bootstrap-vue'
window.axios = require('axios');
window.Vue = require('vue');

let qs = require('qs');
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


Vue.use(BootstrapVue);
Vue.component('search-list', {
    name: "SearchList",
    template: `#search-list`,
    props: ['config', 'action', 'totalItems', 'getCurrentPage', 'getCategory',  'getLimit'],
    delimiters: ['${', '}'],
    data() {
        return {
            items: [],
            loading: false,
            perPage: 1,
            currentPage: 1,
            category: null,
            column: null,
            sort: [],
            sortClassAttr: [],
            itemTotal: this.totalItems,
            limit: null,
            searchQuery: ''
        }
    },
    methods: {
        onOpen() {
            this.$refs.popover.$emit('open')
        },
        getItems() {
            this.loading = true;

            let sortValue = this.sort[this.column];

            let data = {
                currentPage: this.currentPage,
                column: this.column,
                sort: sortValue
            };

            if (this.limit != null) {
               // data.limit = this.limit;
            }

            if (this.searchQuery.trim() !== '') {
                data.searchName = this.searchQuery.trim();
            }

            if (this.category != null) {
              //  data.category = this.category;
            }

            data[csrfTokenName] = csrfTokenValue;

            data = {...this.config, ...data};

            axios.post('/show-list', qs.stringify(data))
                .then(({data}) => {
                    this.loading = false;
                    this.items = data.items;

                    if (this.limit === '*') {
                        this.itemTotal = data.params.total;
                    }
                    this.config.total = data.params.total;
                });
        },
        updateList(currentPage) {
            this.currentPage = currentPage;

            this.getItems();
        },
        updateTotal() {
            let self = this;
            let url = self.action + '/total';
            axios.post(url, {})
                .then(({data}) => {
                    this.itemTotal = data;
                });

            return this.itemTotal;
        },
        sortBy(column) {
            this.column = column;
            this.sortClassAttr = [];
            if (this.sort[column] === 'asc') {
                this.sort[column] = 'desc';
                this.sortClassAttr[column] = 'sorting_desc';
            } else {
                this.sort[column] = 'asc';
                this.sortClassAttr[column] = 'sorting_asc';
            }

            this.getItems();
        },
        sortingClass(column) {
            return this.sortClassAttr[column] ? this.sortClassAttr[column]:  'sorting';
        },
        searchName() {
            this.offset = 0;

            if (this.searchQuery.trim() !== '') {
                // show all results
                this.limit = '*';
            } else {
                this.limit = null;
                this.itemTotal = this.totalItems;
            }

            this.getItems();
        }
    },
    mounted() {
        if (this.config.currentPage != null) {
            this.currentPage = this.config.currentPage;
        }

        if (this.config.category != null) {
            this.category = this.config.category;
        }

        this.getItems();
    },
    computed: {
        totalRows() {
            let limit = this.limit;

            if (limit == null) {
                limit = this.this.config.limit;
            }

            return Math.ceil(this.totalItems / limit);
        }
    }
});

